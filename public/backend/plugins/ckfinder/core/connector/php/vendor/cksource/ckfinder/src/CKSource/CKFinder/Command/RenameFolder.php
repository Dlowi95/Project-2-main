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

use CKSource\CKFinder\Acl\Permission;
use CKSource\CKFinder\Event\CKFinderEvent;
use CKSource\CKFinder\Event\RenameFolderEvent;
use CKSource\CKFinder\Exception\InvalidRequestException;
use CKSource\CKFinder\Filesystem\Folder\WorkingFolder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class RenameFolder extends CommandAbstract
{
    protected $requestMethod = Request::METHOD_POST;

    protected $requires = [Permission::FOLDER_RENAME];

    public function execute(Request $request, WorkingFolder $workingFolder, EventDispatcher $dispatcher)
    {
        // The root folder cannot be renamed.
        if ('/' === $workingFolder->getClientCurrentFolder()) {
            throw new InvalidRequestException('Cannot rename resource type root folder');
        }

        $newFolderName = (string) $request->query->get('newFolderName');

        $renameFolderEvent = new RenameFolderEvent($this->app, $workingFolder, $newFolderName);

        $dispatcher->dispatch($renameFolderEvent, CKFinderEvent::RENAME_FOLDER);

        if (!$renameFolderEvent->isPropagationStopped()) {
            $newFolderName = $renameFolderEvent->getNewFolderName();

            return $workingFolder->rename($newFolderName);
        }

        return ['renamed' => 0];
    }
}
