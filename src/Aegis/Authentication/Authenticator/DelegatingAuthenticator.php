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
        $this->authenticators[$authenticator->supports()] = $authenticator;

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
    public function supports()
    {
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
        if ( ! isset($this->authenticators[get_class($token)])) {
            throw new \RuntimeException(sprintf(
                'No authentication authenticator found for token: "%s".',
                get_class($token)
            ));
        }

        return $this->authenticators[get_class($token)];
    }
}
