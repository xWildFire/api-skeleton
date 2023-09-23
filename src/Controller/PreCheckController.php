<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PreCheckController extends AbstractController
{
    #[Route('/precheck', name: 'precheck')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'precheck!',
        ]);
    }
}
