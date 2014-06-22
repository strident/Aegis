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

use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Authentication Provider Interface
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface AuthenticationProviderInterface
{
    /**
     * Present a token to authenticate, populated with all required information.
     *
     * @return AuthenticationTokenInterface
     */
    public function present();

    /**
     * Authenticate a token.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return AuthenticationTokenInterface
     */
    public function authenticate(AuthenticationTokenInterface $token);

    /**
     * Returns the name of the class that this provider supports.
     *
     * @return string
     */
    public function supports();
}
