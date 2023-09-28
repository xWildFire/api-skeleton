<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class FlushController extends AbstractController
{
    #[Route('/flush', name: 'flush')]
    public function index(CacheInterface $cache): JsonResponse
    {
        $data = $cache->delete('getdata');

        return $this->json([
            'status' => true,
            'data' => [
                'method' => 'flush',
                'random' => random_int(0, 99999),
            ],
            'error' => null,
        ]);
    }
}
