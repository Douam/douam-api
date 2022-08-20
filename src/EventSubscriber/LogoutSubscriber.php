<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;
use ApiPlatform\Core\OpenApi\Model\Response as ModelResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function onLogoutEvent(LogoutEvent $event): void
    {
        $event->setResponse(new JsonResponse(null, HttpFoundationResponse::HTTP_NO_CONTENT));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
