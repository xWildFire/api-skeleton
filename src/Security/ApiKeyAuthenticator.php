<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private const HEADER_AUTH_NAME = 'apikey';

    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function supports(Request $request): ?bool
    {
        return true;
//        if ($request->headers->has(self::HEADER_AUTH_NAME)) {
//            return true;
//        }
//        throw new CustomUserMessageAuthenticationException('No apikey provided');
    }

    public function authenticate(Request $request): Passport
    {
        $apikey = $request->headers->get(self::HEADER_AUTH_NAME);
        if (null === $apikey) {
            throw new CustomUserMessageAuthenticationException('No apikey provided');
        }

        return new SelfValidatingPassport(new UserBadge($apikey, function (string $userIdentifier): ?UserInterface {
            return $this->userRepository->findOneBy(['apikey' => $userIdentifier]);
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
