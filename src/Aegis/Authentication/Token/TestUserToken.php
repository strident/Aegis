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
use Aegis\User\FakeUser;
use Aegis\User\UserInterface;

/**
 * Test User Token
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class TestUserToken implements AuthenticationTokenInterface
{
    private $authenticated;
    private $user;

    public function __construct()
    {
        $this->setAuthenticated(false);
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
        return $this->authenticated;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthenticated($authenticated)
    {
        $this->authenticated = (bool) $authenticated;

        return $this;
    }
}
