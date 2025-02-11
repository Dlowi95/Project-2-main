<?php

/*
 * CKFinder
 * ========
 * https://ckeditor.com/ckfinder/
 * Copyright (c) 2007-2022, CKSource Holding sp. z o.o. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
 */

namespace CKSource\CKFinder\Command;

use Symfony\Component\HttpFoundation\Request;

class Operation extends CommandAbstract
{
    public function execute(Request $request)
    {
        $operationId = (string) $request->query->get('operationId');

        /** @var \CKSource\CKFinder\Operation\OperationManager $operation */
        $operation = $this->app['operation'];

        if ($request->query->get('abort')) {
            $operation->abort($operationId);
        }

        return $operation->getStatus($operationId);
    }
}
