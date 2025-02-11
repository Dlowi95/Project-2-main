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

namespace CKSource\CKFinder\Cache;

use CKSource\CKFinder\Cache\Adapter\AdapterInterface;

/**
 * The CacheManager class.
 */
class CacheManager
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Constructor.
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Sets the value in cache for a given key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool `true` if successful
     */
    public function set($key, $value)
    {
        return $this->adapter->set($key, $value);
    }

    /**
     * Returns the value for a given key from cache.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->adapter->get($key);
    }

    /**
     * Deletes the value under a given key from cache.
     *
     * @return bool `true` if successful
     */
    public function delete(string $key): bool
    {
        return $this->adapter->delete($key);
    }

    /**
     * Copies the value for a given key to another key.
     *
     * @param string $sourceKey
     * @param string $targetKey
     *
     * @return bool `true` if successful
     */
    public function copy($sourceKey, $targetKey)
    {
        $value = $this->adapter->get($sourceKey);

        if (null === $value) {
            return false;
        }

        return $this->adapter->set($targetKey, $value);
    }

    /**
     * Moves the value for a given key to another key.
     *
     * @param string $sourceKey
     * @param string $targetKey
     *
     * @return bool `true` if successful
     */
    public function move($sourceKey, $targetKey)
    {
        return $this->copy($sourceKey, $targetKey) && $this->delete($sourceKey);
    }

    /**
     * Deletes all cache entries with a given key prefix.
     *
     * @param string $keyPrefix
     *
     * @return bool `true` if successful
     */
    public function deleteByPrefix($keyPrefix)
    {
        return $this->adapter->deleteByPrefix($keyPrefix);
    }

    /**
     * Changes the prefix for all entries given a key prefix.
     *
     * @param string $sourcePrefix
     * @param string $targetPrefix
     *
     * @return bool `true` if successful
     */
    public function changePrefix($sourcePrefix, $targetPrefix)
    {
        return $this->adapter->changePrefix($sourcePrefix, $targetPrefix);
    }
}
