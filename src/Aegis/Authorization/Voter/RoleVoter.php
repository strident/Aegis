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

use Aegis\Authorization\Voter\VoterInterface;
use Aegis\Token\TokenInterface;

/**
 * Role Voter
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class RoleVoter implements VoterInterface
{
    /**
     * {@inheritDoc}
     */
    public function vote(TokenInterface $token, array $attributes, $object = null)
    {
        $roles = $token->getRoles();
        $result = VoterInterface::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if ( ! $this->supportsAttribute($attribute)) {
                continue;
            }

            $result = VoterInterface::ACCESS_DENIED;

            if (in_array($attribute, $roles)) {
                $result = VoterInterface::ACCESS_GRANTED;
            }
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsAttribute($attribute)
    {
        return 0 === strpos($attribute, 'ROLE_');
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($object)
    {
        return true;
    }
}
