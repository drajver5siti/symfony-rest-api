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

        $exists = count($repo->findBy([
            "username" => $command->getUsername()
        ]));

        if ($exists)
            throw new UserAlreadyExistsException(400, 'User already exists.');

        $user = new User();
        $user
            ->setUsername($command->getUsername())
            ->setPassword($command->getPassword())
            ->setAge($command->getAge());

        $hashedPassword = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);


        $this->dm->persist($user);
        $this->dm->flush();

        return new Response('', 200);
    }
}
