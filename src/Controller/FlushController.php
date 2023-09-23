<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FlushController extends AbstractController
{
    #[Route('/flush', name: 'flush')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'flush!',
        ]);
    }
}
