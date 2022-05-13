<?php

namespace App\Handlers;

use App\Commands\RegisterUserCommand;
use App\Documents\User;
use App\Exceptions\UserAlreadyExistsException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserHandler
{

    private $hasher;
    private $dm;

    public function __construct(UserPasswordHasherInterface $hasher, DocumentManager $dm)
    {
        $this->hasher = $hasher;
        $this->dm = $dm;
    }
    public function handle(RegisterUserCommand $command)
    {
        $repo = $this->dm->getRepository(User::class);
        $data = $command->getData();

        $exists = count($repo->findBy([
            "username" => $data['username']
        ]));

        if ($exists)
            throw new UserAlreadyExistsException(400, 'User already exists.');

        $user = new User();
        $user
            ->setUsername($data['username'])
            ->setPassword($data['password'])
            ->setAge($data['age']);

        $hashedPassword = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);


        $this->dm->persist($user);
        $this->dm->flush();

        return new Response('', 200);
    }
}
