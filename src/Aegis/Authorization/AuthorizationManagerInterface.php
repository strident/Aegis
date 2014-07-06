<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authorization;

use Aegis\Token\TokenInterface;

/**
 * Authorization Manager Interface
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface AuthorizationManagerInterface
{
    /**
     * Use the voters to decide on whether attributes are granted to a token,
     * and optionally for an object.
     *
     * @param TokenInterface $token
     * @param array          $attributes
     * @param mixed          $object
     *
     * @return boolean
     */
    public function decide(TokenInterface $token, array $attributes, $object = null);
}
