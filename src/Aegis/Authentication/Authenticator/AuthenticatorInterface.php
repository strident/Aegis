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
     * @param TokenInterface $token
     *
     * @return TokenInterface
     */
    public function authenticate(TokenInterface $token);

    /**
     * Present a token if possible
     *
     * @return TokenInterface
     */
    public function present();

    /**
     * Returns the name of the class that this provider supports.
     *
     * @param TokenInterface $token
     *
     * @return string
     */
    public function supports(TokenInterface $token);
}
