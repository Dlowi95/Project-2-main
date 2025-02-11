<?php

namespace Intervention\Image\Drivers\Gd\Modifiers;

use Intervention\Image\Drivers\DriverSpecializedModifier;
use Intervention\Image\Interfaces\ImageInterface;

/**
 * @property int $amount
 */
class SharpenModifier extends DriverSpecializedModifier
{
    public function apply(ImageInterface $image): ImageInterface
    {
        $matrix = $this->matrix();
        foreach ($image as $frame) {
            imageconvolution($frame->native(), $matrix, 1, 0);
        }

        return $image;
    }

    private function matrix(): array
    {
        $min = $this->amount >= 10 ? $this->amount * -0.01 : 0;
        $max = $this->amount * -0.025;
        $abs = ((4 * $min + 4 * $max) * -1) + 1;

        return [
            [$min, $max, $min],
            [$max, $abs, $max],
            [$min, $max, $min]
        ];
    }
}
