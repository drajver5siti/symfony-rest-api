<?php

namespace App\Controller;

use App\Commands\RegisterUserCommand;
use App\Exceptions\InvalidDataException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function index(Request $request, CommandBus $commandBus)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username'], $data['password'], $data['age']))
            throw new InvalidDataException(400, 'Invalid registration data.');

        $command = new RegisterUserCommand($data);
        return $commandBus->handle($command);
    }
}
