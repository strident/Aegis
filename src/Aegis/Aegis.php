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
use Aegis\Authentication\Result;
use Aegis\Authorization\AuthorizationManagerInterface;
use Aegis\Storage\StorageInterface;
use Aegis\User\UserInterface;
use Aegis\Token\AnonymousToken;
use Aegis\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Main entry point of Aegis.
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class Aegis
{
    protected $authenticator;
    protected $authorizationManager;
    protected $initialized = false;
    protected $storage;
    protected $token;

    public function __construct(
        AuthenticatorInterface $authenticator,
        AuthorizationManagerInterface $authorizationManager,
        StorageInterface $storage
    )
    {
        $this->setAuthenticator($authenticator);
        $this->setAuthorizationManager($authorizationManager);
        $this->setStorage($storage);
    }

    /**
     * Authenticate a token, or ask providers to provide a token to authenticate
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return Result
     */
    public function authenticate(TokenInterface $token = null)
    {
        // If no token is passed in, try and find one from the authenticator
        $token = $token ?: $this->authenticator->present();

        if ( ! $token instanceof TokenInterface) {
            return new Result(Result::FAILURE_NO_TOKEN);
        }

        $result = new Result();

        try {
            $token = $this->authenticator->authenticate($token);
        } catch (AuthenticationException $e) {
            $result->setCode($e->getCode());
            $result->setException($e);
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
     * Check if the current token is granted permissions.
     *
     * @param mixed  $attributes
     * @param object $object
     *
     * @return boolean
     */
    public function isGranted($attributes, $object = null)
    {
        if ( ! is_array($attributes)) {
            $attributes = [$attributes];
        }

        return $this->authorizationManager->decide($this->getToken(), $attributes, $object);
    }

    /**
     * Is the current token authenticated? (This doens't necessarily mean the
     * user has permissions)
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        if ($this->getToken()->getUser() instanceof UserInterface) {
            return true;
        }

        return false;
    }

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
     * Set authorization manager.
     *
     * @param AuthorizationManagerInterface $authorizationManager
     *
     * @return Aegis
     */
    public function setAuthorizationManager(AuthorizationManagerInterface $authorizationManager)
    {
        $this->authorizationManager = $authorizationManager;

        return $this;
    }

    /**
     * Get authorization manager.
     *
     * @return AuthorizationManagerInterface
     */
    public function getAuthorizationManager()
    {
        return $this->authorizationManager;
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
    protected function setToken(TokenInterface $token)
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
