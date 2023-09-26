<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private const HEADER_AUTH_NAME = 'apikey';

    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::HEADER_AUTH_NAME);
    }

    public function authenticate(Request $request): Passport
    {
        $apikey = $request->headers->get(self::HEADER_AUTH_NAME);
        if (null === $apikey) {
            throw new CustomUserMessageAuthenticationException(
                'Auth token not found (header: "{{ header }}")',
                ['{{ header }}' => self::HEADER_AUTH_NAME],
            );
        }

        return new SelfValidatingPassport(new UserBadge($apikey));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw $exception;
    }
}
