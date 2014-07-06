<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis;

use Aegis\Exception\AuthenticationException;
use Aegis\Authentication\Authenticator\AuthenticatorInterface;
use Aegis\Authentication\Token\AnonymousToken;
use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Aegis\Storage\StorageInterface;
use Aegis\User\UserInterface;
use Aegis\Result;
use Symfony\Component\HttpFoundation\Request;

/**
 * Main entry point of Aegis.
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class Aegis
{
    protected $authenticator;
    protected $initialized = false;
    protected $storage;
    protected $token;

    /**
     * Initialize Aegis.
     *
     * Prepares a token to authorize against. Always provides a token.
     *
     * @return Aegis
     *
     * @throws \RuntimeException
     */
    public function initialize()
    {
        if ( ! isset($this->authenticator)) {
            throw new \RuntimeException('Aegis is missing an authentication authenticator.');
        }

        if ( ! isset($this->storage)) {
            throw new \RuntimeException('Aegis is missing a persistent storage engine.');
        }

        // Set inital token to be anonymous until proven otherwise
        $this->setToken(new AnonymousToken());

        // Attempt to read token from persistent storage
        $token = $this->storage->read();

        // Re-authenticate stored token
        if ($token instanceof AuthenticationTokenInterface) {
            $result = $this->authenticate($token);
        }

        $this->initialized = true;

        return $this;
    }

    /**
     * Authenticate a token, or ask providers to provide a token to authenticate
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return Result
     */
    public function authenticate(AuthenticationTokenInterface $token = null)
    {
        // If no token is passed in, try and find one from the authenticator
        $token = $token ?: $this->authenticator->present();

        if ( ! $token instanceof AuthenticationTokenInterface) {
            return new Result(Result::NO_TOKEN);
        }

        $result = new Result();

        try {
            $token = $this->authenticator->authenticate($token);
        } catch (AuthenticationException $e) {
            // If all other types of exception have been missed, but the
            // exception thrown is still an authentication exception catch it,
            // allowing any non-authentication related exceptions to bubble up.
            $result->setCode(Result::UNKNOWN);
            $result->setToken($e->getToken());

            return $result;
        }

        $result->setCode(Result::SUCCESS);
        $result->setToken($token);

        $this->storage->write($token);
        $this->setToken($token);

        return $result;
    }

    /**
     * Set authenticator.
     *
     * @param AuthenticatorInterface $authenticator
     *
     * @return Aegis
     */
    public function setAuthenticator(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;

        return $this;
    }

    /**
     * Get authenticator.
     *
     * @return AuthenticatorInterface
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }

    /**
     * Set storage.
     *
     * @param StorageInterface $storage
     *
     * @return Aegis
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get storage.
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set token.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return Aegis
     */
    protected function setToken(AuthenticationTokenInterface $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return AuthenticationTokenInterface
     */
    public function getToken()
    {
        if ( ! $this->initialized) {
            $this->initialize();
        }

        return $this->token;
    }
}
