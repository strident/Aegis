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

use Aegis\Authentication\Token\AuthenticationTokenInterface;

/**
 * Authentication Result
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class Result
{
    protected $code;
    protected $token;

    const SUCCESS  = 1;
    const UNKNOWN  = 0;
    const NO_TOKEN = -1;

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
