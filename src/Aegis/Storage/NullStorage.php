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

use Aegis\Storage\StorageInterface;

/**
 * Null Storage
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class NullStorage implements StorageInterface
{
    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function write($content)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        return $this;
    }
}
