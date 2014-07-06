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

use Aegis\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Authenticator Interface
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface AuthenticatorInterface
{
    /**
     * Authenticate a token.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return AuthenticationTokenInterface
     */
    public function authenticate(TokenInterface $token);

    /**
     * Returns the name of the class that this provider supports.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return string
     */
    public function supports(TokenInterface $token);
}
