<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Util;

use function array_keys;
use function array_merge;
use function array_reverse;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class Reflection
{
    /**
     * @psalm-param class-string $className
     * @psalm-param non-empty-string $methodName
     *
     * @psalm-return array{file: non-empty-string, line: non-negative-int}
     */
    public static function sourceLocationFor(string $className, string $methodName): array
    {
        try {
            $reflector = new ReflectionMethod($className, $methodName);

            $file = $reflector->getFileName();
            $line = $reflector->getStartLine();
        } catch (ReflectionException) {
            $file = 'unknown';
            $line = 0;
        }

        return [
            'file' => $file,
            'line' => $line,
        ];
    }

    /**
     * @psalm-return list<ReflectionMethod>
     */
    public static function publicMethodsInTestClass(ReflectionClass $class): array
    {
        return self::filterMethods($class, ReflectionMethod::IS_PUBLIC);
    }

    /**
     * @psalm-return list<ReflectionMethod>
     */
    public static function methodsInTestClass(ReflectionClass $class): array
    {
        return self::filterMethods($class, null);
    }

    /**
     * @psalm-return list<ReflectionMethod>
     */
    private static function filterMethods(ReflectionClass $class, ?int $filter): array
    {
        $methodsByClass = [];

        foreach ($class->getMethods($filter) as $method) {
            $declaringClassName = $method->getDeclaringClass()->getName();

            if ($declaringClassName === TestCase::class) {
                continue;
            }

            if ($declaringClassName === Assert::class) {
                continue;
            }

            if (!isset($methodsByClass[$declaringClassName])) {
                $methodsByClass[$declaringClassName] = [];
            }

            $methodsByClass[$declaringClassName][] = $method;
        }

        $methods = [];

        foreach (array_reverse(array_keys($methodsByClass)) as $className) {
            $methods = array_merge($methods, $methodsByClass[$className]);
        }

        return $methods;
    }
}
