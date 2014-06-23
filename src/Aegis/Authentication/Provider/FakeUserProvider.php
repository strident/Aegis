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

use Aegis\Authentication\Provider\AuthenticationProviderInterface;
use Aegis\Authentication\Token\AuthenticationTokenInterface;
use Aegis\Authentication\Token\TestUserToken;
use Aegis\User\TestUser;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fake User Provider.
 *
 * For debugging purposes only.
 *
 * @author Elliot Wright <elliot@elliotwright.co>
 */
class FakeUserProvider implements AuthenticationProviderInterface
{
    private $request;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function present()
    {
        if ('true' === $this->request->query->get('login')) {
            return new TestUserToken();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(AuthenticationTokenInterface $token)
    {
        // This would be where you'd grab the real user object.
        $token->setUser(new TestUser());

        // Do something to validate user credentials from token
        $token->setAuthenticated(count($token->getUser()->getRoles()) > 0);

        return $token;
    }

    /**
     * {@inheritDoc}
     */
    public function supports()
    {
        return TestUserToken::class;
    }
}
