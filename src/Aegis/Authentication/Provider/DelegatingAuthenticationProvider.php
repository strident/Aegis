<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authentication\Provider;

use Aegis\Authentication\Provider\AuthenticationProviderInterface;
use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Aegis\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Delegating authentication provider.
 *
 * Delegates authentication to registered authentication providers.
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class DelegatingAuthenticationProvider implements AuthenticationProviderInterface
{
    private $providers = [];

    /**
     * Add an authentication provider.
     *
     * @param AuthenticationProviderInterface $provider
     *
     * @return DelegatingAuthenticationManager
     */
    public function addProvider(AuthenticationProviderInterface $provider)
    {
        $this->providers[$provider->supports()] = $provider;

        return $this;
    }

    /**
     * Clear all registered authentication providers.
     *
     * @return DelegatingAuthenticationManager
     */
    public function clearProviders()
    {
        $this->providers = [];

        return $this;
    }

    /**
     * Get a provider by it's supported token.
     *
     * @param string $name
     *
     * @return AuthenticationProviderInterface
     */
    public function getProvider($name)
    {
        return ! isset($this->providers[$name]) ?: $this->providers[$name];
    }

    /**
     * Remove a provider by it's supported token.
     *
     * @param string $name
     *
     * @return AuthenticationProviderInterface
     */
    public function removeProvider($name)
    {
        unset($this->providers[$name]);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function present()
    {
        foreach ($this->providers as $provider) {
            $token = $provider->present();

            // Accept the first token that's allow, this will be an
            // implementation-specific issue... for now.
            if ($token instanceof AuthenticationTokenInterface) {
                return $token;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(AuthenticationTokenInterface $token)
    {
        $provider = $this->delegateProvider($token);

        return $provider->authenticate($token);
    }

    /**
     * {@inheritDoc}
     */
    public function supports()
    {

    }

    /**
     * Delegate a provider for a token.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return AuthenticationProviderInterface
     */
    private function delegateProvider(AuthenticationTokenInterface $token)
    {
        if ( ! isset($this->providers[get_class($token)])) {
            throw new \RuntimeException(sprintf(
                'No authentication provider found for token: "%s".',
                get_class($token)
            ));
        }

        return $this->providers[get_class($token)];
    }
}
