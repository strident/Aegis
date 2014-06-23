<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authentication\Token;

use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Aegis\User\AnonymousUser;
use Aegis\User\UserInterface;

/**
 * Anonymous Token
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class AnonymousToken implements AuthenticationTokenInterface
{
    private $user;

    public function __construct()
    {
        $this->user = 'AnonymousUser';
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentials()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function flushCredentials()
    {
        // Doesn't need to do anything in this class
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthenticated()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthenticated($authenticated)
    {
        // Doesn't need to do anything in this class
        return $this;
    }
}
