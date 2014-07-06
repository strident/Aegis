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

use Aegis\Authorization\Voter\VoterInterface;
use Aegis\Token\TokenInterface;

/**
 * Authorization Manager
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class AuthorizationManager implements AuthorizationManagerInterface
{
    protected $voters = [];

    /**
     * {@inheritDoc}
     */
    public function decide(TokenInterface $token, array $attributes, $object = null)
    {
        $grant = 0;

        foreach ($attributes as $attribute) {
            foreach ($this->voters as $voter) {
                $result = $voter->vote($token, [$attribute], $object);

                switch ($result) {
                    case VoterInterface::ACCESS_GRANTED:
                        $grant++;
                        break;

                    case VoterInterface::ACCESS_DENIED:
                        return false;

                    default:
                        break;
                }
            }
        }

        // If there were no deny votes
        if ($grant > 0) {
            return true;
        }

        return false;
    }

    /**
     * Add an authorization voter.
     *
     * @param AuthorizationVoterInterface $voter
     *
     * @return AuthorizationManager
     */
    public function addVoter(VoterInterface $voter)
    {
        $this->voters[get_class($voter)] = $voter;

        return $this;
    }

    /**
     * Clear all voters.
     *
     * @return AuthorizationManager
     */
    public function clearVoters()
    {
        $this->voters = [];

        return $this;
    }

    /**
     * Get a voter.
     *
     * @param string $name
     *
     * @return AuthorizationVoterInterface
     */
    public function getVoter($name)
    {
        return ! isset($this->voters[$name]) ?: $this->voters[$name];
    }

    /**
     * Remove a voter.
     *
     * @param string $name
     *
     * @return AuthorizationManager
     */
    public function removeVoter($name)
    {
        unset($this->voters[$name]);

        return $this;
    }
}
