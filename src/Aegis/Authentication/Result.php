<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authentication;

use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Aegis\Exception\AuthenticationException;

/**
 * Authentication Result
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class Result
{
    protected $code;
    protected $exception;
    protected $token;

    const SUCCESS  = 1;
    const FAILURE  = 0;
    const FAILURE_UNKNOWN  = -1;
    const FAILURE_BAD_CREDENTIALS = -2;
    const FAILURE_NO_TOKEN = -3;
    const FAILURE_LOCKED = -4;

    /**
     * Constructor.
     *
     * @param integer $code
     */
    public function __construct($code = null)
    {
        $this->code = $code;
    }

    /**
     * Set code.
     *
     * @param integer $code
     *
     * @return Result
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the exception related to the result if any.
     *
     * @param AuthenticationException $e
     *
     * @return Result
     */
    public function setException(AuthenticationException $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Get the exception
     *
     * @return AuthenticationException
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set token.
     *
     * @param AuthenticationTokenInterface $token
     *
     * @return Result
     */
    public function setToken(AuthenticationTokenInterface $token)
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
        return $this->token;
    }
}
