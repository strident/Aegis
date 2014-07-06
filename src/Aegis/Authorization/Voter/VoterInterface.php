<?php

/*
 * This file is part of Aegis.
 *
 * (c) Elliot Wright <elliot@elliotwright.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aegis\Authorization\Voter;

use Aegis\Token\TokenInterface;

/**
 * Voter Interace
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
interface VoterInterface
{
    const ACCESS_GRANTED = 1;
    const ACCESS_ABSTAIN = 0;
    const ACCESS_DENIED  = -1;

    /**
     * Vote based on the given parameters.
     *
     * Returns one of the following:
     * ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     *
     * @param TokenInterface $token
     * @param array          $attributes
     * @param mixed          $object
     *
     * @return int
     */
    public function vote(TokenInterface $token, array $attributes, $object = null);

    /**
     * Does this voter support the given attribute?
     *
     * @param mixed $attribute
     *
     * @return boolean
     */
    public function supportsAttribute($attribute);

    /**
     * Does this voter support the given object?
     *
     * @param mixed $object
     *
     * @return boolean
     */
    public function supportsClass($object);
}
