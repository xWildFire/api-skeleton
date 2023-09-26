<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ExceptionListener
{
    #[AsEventListener]
    public function onResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException) {
            if ($exception->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
                $error = [
                    'http_code' => 401,
                    'message' => 'Unauthorized',
                    'code' => 100,
                    'description' => 'Unauthorized Apikey',
                ];
            } elseif ($exception->getStatusCode() === Response::HTTP_NOT_FOUND) {
                $error = [
                    'http_code' => 404,
                    'message' => 'Not Found',
                    'code' => 101,
                    'description' => 'Not Found',
                ];
            }
        }

        $error ??= [
            'http_code' => 500,
            'message' => 'Internal Server Error',
            'code' => 109,
            'description' => 'Internal Server Error',
        ];

        if (!$error) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'status' => false,
            'data' => [
                'available' => false
            ],
            'error' => [
                'http_code' => $error['http_code'],
                'message' => $error['message'],
                'code' => $error['code'],
                'description' => $error['description']
            ]
        ], $error['http_code']));
    }
}
