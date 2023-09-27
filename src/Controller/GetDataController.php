<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetDataController extends AbstractController
{
    #[Route('/getdata', name: 'getdata')]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => true,
            'data' => [
                'method' => 'getdata',
                'hello' => 'world',
            ],
            'error' => null,
        ]);
    }
}
