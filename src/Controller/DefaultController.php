<?php

namespace App\Controller;

use App\Documents\User;
use App\Transformers\UserTransformer;
use App\Managers\DefaultManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use League\Fractal\Resource\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/api')]
class DefaultController extends AbstractController
{



    #[Route('/users', name: 'app_default')]
    public function index(DocumentManager $dm, Security $security): Response
    {

        $repository = $dm->getRepository(User::class);
        // $limit = (int) htmlspecialchars($_GET['limit'] ?? null);
        // dd($limit);

        // $repository->findByEmail() ?? 
        // $users = $repository->findByEmail("filip.pavlovski@gmail.com");
        // $query = $dm->createQueryBuilder(User::class);


        $users = $repository->findAll();


        $resource = new Collection($users, new UserTransformer($security), 'users');
        $result = DefaultManager::getInstance()->createData($resource);
        // dd($result);
        return $this->json($result);
    }
}
