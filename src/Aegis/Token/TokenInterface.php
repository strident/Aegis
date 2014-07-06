<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Token;

use Aegis\User\UserInterface;

/**
 * Token Interface
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface TokenInterface
{
    /**
     * Get roles.
     *
     * @return array
     */
    public function getRoles();

    /**
     * Get user.
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Set user.
     *
     * @param UserInterface $user
     *
     * @return AuthenticationTokenInterface
     */
    public function setUser(UserInterface $user);

    /**
     * Get credentials.
     *
     * @return mixed
     */
    public function getCredentials();

    /**
     * Flush credentials attached to this token.
     *
     * @return AuthenticationTokenInterface
     */
    public function flushCredentials();

    /**
     * Is this token authenticated?
     *
     * @return boolean
     */
    public function isAuthenticated();

    /**
     * Set authenticated.
     *
     * @param boolean $authenticated
     *
     * @return AuthenticationTokenInterface
     */
    public function setAuthenticated($authenticated);
}
