<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authentication\Authenticator;

use Aegis\Authentication\Authenticator\AuthenticatorInterface;
use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Aegis\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Delegating authenticator.
 *
 * Delegates authentication to registered authenticators.
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class DelegatingAuthenticator implements AuthenticatorInterface
{
    private $authenticators = [];

    /**
     * Add an authentication authenticator.
     *
     * @param AuthenticatorInterface $authenticator
     *
     * @return DelegatingAuthenticator
     */
    public function addAuthenticator(AuthenticatorInterface $authenticator)
    {
        $this->authenticators[] = $authenticator;

        return $this;
    }

    /**
     * Clear all registered authentication authenticators.
     *
     * @return DelegatingAuthenticator
     */
    public function clearAuthenticators()
    {
        $this->authenticators = [];

        return $this;
    }

    /**
     * Get a authenticator by it's supported token.
     *
     * @param string $name
     *
     * @return AuthenticatorInterface
     */
    public function getAuthenticator($name)
    {
        return ! isset($this->authenticators[$name]) ?: $this->authenticators[$name];
    }

    /**
     * Remove a authenticator by it's supported token.
     *
     * @param string $name
     *
     * @return DelegatingAuthenticator
     */
    public function removeAuthenticator($name)
    {
        unset($this->authenticators[$name]);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(AuthenticationTokenInterface $token)
    {
        $authenticator = $this->delegateAuthenticator($token);

        return $authenticator->authenticate($token);
    }

    /**
     * {@inheritDoc}
     */
    public function supports(AuthenticationTokenInterface $token)
    {
        return (bool) $this->resolveAuthenticator($token);
    }

    /**
     * Delegate a authenticator for a token.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return DelegatingAuthenticator
     */
    private function delegateAuthenticator(AuthenticationTokenInterface $token)
    {
        if ( ! $authenticator = $this->resolveAuthenticator($token)) {
            throw new \RuntimeException(sprintf(
                'No authentication authenticator found for token: "%s".',
                get_class($token)
            ));
        }

        return $authenticator;
    }

    /**
     * Resolve a token to its authenticator.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return mixed
     */
    private function resolveAuthenticator(AuthenticationTokenInterface $token)
    {
        foreach ($this->authenticators as $authenticator) {
            if ($authenticator->supports($token)) {
                return $authenticator;
            }
        }

        return false;
    }
}
