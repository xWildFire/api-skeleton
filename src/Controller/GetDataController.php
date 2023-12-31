<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GetDataController extends AbstractController
{
    #[Route('/getdata', name: 'getdata')]
    public function index(CacheInterface $cache): JsonResponse
    {
        $data = $cache->get('getdata', function (ItemInterface $cache) {
            $cache->expiresAfter(60);

            return [
                'method' => 'getdata',
                'random' => random_int(0, 99999),
            ];
        });

        return $this->json([
            'status' => true,
            'data' => $data,
            'error' => null,
        ]);
    }
}
