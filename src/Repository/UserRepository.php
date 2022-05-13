<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class UserRepository extends DocumentRepository
{
    public function findByEmail(string $email)
    {
        return $this->findBy(['email' => $email]);
    }
}
