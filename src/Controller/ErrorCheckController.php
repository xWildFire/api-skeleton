<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ErrorCheckController extends AbstractController
{
    #[Route('/error_check', name: 'error_check')]
    public function index(): JsonResponse
    {
        $test = ['heh'];

        $test2 = $test['abaaca'];

        $test3 = false;
        $test3[] = 2;

        $test4 = 1 / 0;

        return $this->json([
            'message' => 'getdata!',
        ]);
    }
}
