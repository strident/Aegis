<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authentication\User\Provider;

use Aegis\Authentication\User\UserInterface;

/**
 * User Provider Interface
 *
 * Used as a gateway to access users, to authenticate them.
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface UserProviderInterface
{
    /**
     * Find a user by their identifier (e.g. username)
     *
     * @param mixed $identifier
     *
     * @return mixed
     */
    public function findUserByIdentifier($identifier);

    /**
     * True if the user is supported by this provider.
     *
     * @param UserInterface $user
     *
     * @return boolean
     */
    public function isSupported(UserInterface $user);
}
