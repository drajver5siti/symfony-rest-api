<?php

namespace App\EventListeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Documents\User;
use Symfony\Component\Security\Core\Security;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    private $security;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, Security $security)
    {
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        /**
         * @var User
         */
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['isAdmin'] = $this->security->isGranted('ROLE_ADMIN');
        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}
