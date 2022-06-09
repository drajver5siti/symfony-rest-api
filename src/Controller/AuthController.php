<?php

namespace App\Controller;

use League\Tactician\CommandBus;
use App\Commands\RegisterUserCommand;
use App\Constraints\RegisterUserConstraint;
use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class AuthController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, CommandBus $commandBus, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);


        $errors = $validator->validate($data, RegisterUserConstraint::get());

        if ($errors->count())
            throw new ValidationException(400, $errors);

        $command = new RegisterUserCommand($data['username'], $data['password'], $data['age']);
        return $commandBus->handle($command);
    }


    #[Route('/login_check', name: 'api_login', methods: ['POST'])]
    public function login(): Response
    {
        return new Response();
    }
}
