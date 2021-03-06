<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Exception;

use Aegis\Authentication\Result;
use Aegis\Token\TokenInterface;

/**
 * Authentication Exception
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class AuthenticationException extends \RuntimeException
{
    private $token;

    /**
     * Constructor.
     *
     * @param TokenInterface $token
     * @param string         $message
     * @param integer        $code
     * @param \Exception     $previous
     */
    public function __construct(TokenInterface $token, $message = '', $code = Result::FAILURE, \Exception $previous = null)
    {
        $this->token = $token;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get token.
     *
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }
}
