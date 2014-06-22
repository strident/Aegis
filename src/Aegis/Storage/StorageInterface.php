<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Storage;

/**
 * Storage Interface
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface StorageInterface
{
    /**
     * Returns true if the storage is empty.
     *
     * @return boolean
     */
    public function isEmpty();

    /**
     * Read the storage.
     *
     * @return mixed
     */
    public function read();

    /**
     * Write the content to the storage.
     *
     * @param mixed $content
     *
     * @return StorageInterface
     */
    public function write($content);

    /**
     * Clear the contents of the storage.
     *
     * @return StorageInterface
     */
    public function clear();
}
