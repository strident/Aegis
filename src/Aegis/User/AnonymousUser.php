<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\User;

use Aegis\User\UserInterface;

class AnonymousUser implements UserInterface
{
    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return 'AnonymousUser';
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return [];
    }
}
