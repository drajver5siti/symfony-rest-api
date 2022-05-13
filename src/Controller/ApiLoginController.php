<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiLoginController extends AbstractController
{
    #[Route('/login_check', name: 'api_login', methods: ['POST'])]
    public function index(): Response
    {
        return new Response();
    }
}
