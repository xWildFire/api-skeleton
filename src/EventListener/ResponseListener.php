<?php

namespace App\EventListener;

use App\Entity\Request;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class ResponseListener
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Security               $security
    )
    {
    }

    #[AsEventListener(priority: -10000)]
    public function onResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }


        $request = $event->getRequest();
        $response = $event->getResponse();

        $requestDb = new Request();
        $requestDb->setUser($this->security->getUser());
        $requestDb->setUri($request->getRequestUri());
        $requestDb->setArgument($request->getPayload()->all());
        $requestDb->setHeader($request->headers->all());
        $requestDb->setQuery($request->query->all());
        $requestDb->setIp($request->getClientIp());
        $requestDb->setResponse(json_decode($response->getContent(), true));
        $requestDb->setCreatedAt(DateTimeImmutable::createFromFormat('U.u', (string)$request->server->get('REQUEST_TIME_FLOAT')));
        $requestDb->setFinishedAt(DateTimeImmutable::createFromFormat('U.u', (string)microtime(true)));

        $this->entityManager->persist($requestDb);

        $this->entityManager->flush();
    }
}
