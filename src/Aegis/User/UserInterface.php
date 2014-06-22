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

/**
 * User Interface
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface UserInterface
{
    /**
     * Get username of user.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get roles of the user.
     *
     * @return array
     */
    public function getRoles();
}
