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
use CKSource\CKFinder\Event\RenameFileEvent;
use CKSource\CKFinder\Exception\InvalidNameException;
use CKSource\CKFinder\Filesystem\File\RenamedFile;
use CKSource\CKFinder\Filesystem\Folder\WorkingFolder;
use Exception;
use League\Flysystem\FilesystemException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

class RenameFile extends CommandAbstract
{
    protected $requestMethod = Request::METHOD_POST;

    protected $requires = [Permission::FILE_RENAME];

    /**
     * @throws InvalidNameException
     * @throws Exception|FilesystemException
     */
    public function execute(Request $request, WorkingFolder $workingFolder, EventDispatcher $dispatcher): array
    {
        $fileName = (string) $request->query->get('fileName');
        $newFileName = (string) $request->query->get('newFileName');

        if (null === $fileName || null === $newFileName) {
            throw new InvalidNameException('Invalid file name');
        }

        $renamedFile = new RenamedFile(
            $newFileName,
            $fileName,
            $workingFolder->getClientCurrentFolder(),
            $workingFolder->getResourceType(),
            $this->app
        );

        $renamed = false;

        if ($renamedFile->isValid()) {
            $renamedFileEvent = new RenameFileEvent($this->app, $renamedFile);

            $dispatcher->dispatch($renamedFileEvent, CKFinderEvent::RENAME_FILE);

            if (!$renamedFileEvent->isPropagationStopped()) {
                $renamed = $renamedFile->doRename();
            }
        }

        return [
            'name' => $fileName,
            'newName' => $renamedFile->getNewFileName(),
            'renamed' => (int) $renamed,
        ];
    }
}
