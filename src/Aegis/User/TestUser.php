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

/**
 * Fake User
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class TestUser implements UserInterface
{
    public function getUsername()
    {
        return 'Seer';
    }

    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }
}
