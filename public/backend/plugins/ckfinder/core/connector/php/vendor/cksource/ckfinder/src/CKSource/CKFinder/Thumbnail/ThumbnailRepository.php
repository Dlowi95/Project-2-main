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

namespace CKSource\CKFinder\Thumbnail;

use CKSource\CKFinder\Backend\Backend;
use CKSource\CKFinder\CKFinder;
use CKSource\CKFinder\Config;
use CKSource\CKFinder\Event\CKFinderEvent;
use CKSource\CKFinder\Event\ResizeImageEvent;
use CKSource\CKFinder\Filesystem\Path;
use CKSource\CKFinder\ResourceType\ResourceType;
use League\Flysystem\FilesystemException;

/**
 * The ThumbnailRepository class.
 *
 * A class responsible for thumbnail management.
 */
class ThumbnailRepository
{
    /**
     * @var CKFinder
     */
    protected $app;

    /**
     * @var Config
     */
    protected $config;

    /**
     * The Backend where thumbnails are stored.
     *
     * @var Backend
     */
    protected $thumbsBackend;

    /**
     * Event dispatcher.
     */
    protected $dispatcher;

    /**
     * Constructor.
     */
    public function __construct(CKFinder $app)
    {
        $this->app = $app;
        $this->config = $app['config'];
        $this->thumbsBackend = $app['backend_factory']->getPrivateDirBackend('thumbs');
        $this->dispatcher = $app['dispatcher'];
    }

    /**
     * Returns the Backend object where thumbnails are stored.
     *
     * @return Backend
     */
    public function getThumbnailBackend()
    {
        return $this->thumbsBackend;
    }

    /**
     * @return CKFinder
     */
    public function getContainer()
    {
        return $this->app;
    }

    /**
     * Returns backend-relative directory path where
     * thumbnails are stored.
     *
     * @return string
     */
    public function getThumbnailsPath()
    {
        return $this->config->getPrivateDirPath('thumbs');
    }

    /**
     * Returns an array of allowed sizes for thumbnails.
     *
     * @return array
     */
    public function getAllowedSizes()
    {
        return $this->config->get('thumbnails.sizes');
    }

    /**
     * Returns information about bitmap support for thumbnails. If bitmap
     * support is disabled, thumbnails for bitmaps will not be generated.
     *
     * @return bool `true` if bitmap support is enabled
     */
    public function isBitmapSupportEnabled()
    {
        return $this->config->get('thumbnails.bmpSupported');
    }

    /**
     * Returns a thumbnail object for a given file defined by the resource type,
     * path and file name.
     * The real size of the thumbnail image will be adjusted to one of the sizes
     * allowed by the thumbnail configuration.
     *
     * @param ResourceType $resourceType    source file resource type
     * @param string       $path            source file directory path
     * @param string       $fileName        source file name
     * @param int          $requestedWidth  requested thumbnail height
     * @param int          $requestedHeight requested thumbnail height
     *
     * @throws \Exception
     */
    public function getThumbnail(ResourceType $resourceType, string $path, string $fileName, int $requestedWidth, int $requestedHeight): Thumbnail
    {
        $thumbnail = new Thumbnail($this, $resourceType, $path, $fileName, $requestedWidth, $requestedHeight);

        if (!$thumbnail->exists()) {
            $thumbnail->create();

            $createThumbnailEvent = new ResizeImageEvent($this->app, $thumbnail);
            $this->dispatcher->dispatch($createThumbnailEvent, CKFinderEvent::CREATE_THUMBNAIL);

            if (!$createThumbnailEvent->isPropagationStopped()) {
                $thumbnail = $createThumbnailEvent->getResizedImage();
                $thumbnail->save();
            }
        } else {
            $thumbnail->load();
        }

        return $thumbnail;
    }

    /**
     * Deletes all thumbnails under the given path defined by the resource type,
     * path and file name.
     *
     * @return bool `true` if deleted successfully
     *
     * @throws FilesystemException
     */
    public function deleteThumbnails(ResourceType $resourceType, string $path, string $fileName = null): bool
    {
        $path = Path::combine($this->getThumbnailsPath(), $resourceType->getName(), $path, $fileName);

        if ($this->thumbsBackend->has($path)) {
            try {
                $this->thumbsBackend->deleteDirectory($path);

                return true;
            } catch (FilesystemException $e) {
                return false;
            }
        }

        return false;
    }
}
