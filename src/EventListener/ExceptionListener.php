<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelInterface;

final class ExceptionListener
{
    public function __construct(private readonly KernelInterface $kernel, private readonly LoggerInterface $logger)
    {

    }

    #[AsEventListener]
    public function onResponse(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException) {
            $error = [
                'http_code' => $exception->getStatusCode(),
                'message' => Response::$statusTexts[$exception->getStatusCode()],
                'description' => $exception->getMessage(),
            ];
        } else {
            $error = [
                'http_code' => 500,
                'message' => 'Internal Server Error',
                'description' => 'Internal Server Error',
            ];
        }

        if ($this->kernel->isDebug() || $this->kernel->getEnvironment() === 'dev') {
            $error['description'] = "{$exception->getMessage()} (line: {$exception->getLine()}, file: {$exception->getFile()})";
            $error['trace'] = $exception->getTrace();

            $previous = $exception->getPrevious();
            if ($previous !== null) {
                $error['previous'] = [
                    'description' => "{$previous->getMessage()} (line: {$previous->getLine()}, file: {$previous->getFile()})",
                    'trace' => $previous->getTrace(),
                ];
            }
        }

        if (!$error) {
            return;
        }

        if ($error['http_code'] >= 500) {
            $this->logger->critical($exception);
        }

        $event->setResponse(new JsonResponse([
            'status' => false,
            'data' => [
                'available' => false,
            ],
            'error' => $error,
        ], $error['http_code']));
    }
}
