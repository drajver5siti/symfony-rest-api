<?php

namespace App\Controller;

use App\Documents\Blog;
use App\Documents\User;
use App\Transformers\UserTransformer;
use App\Managers\DefaultManager;
use App\Transformers\BlogTransformer;
use Doctrine\ODM\MongoDB\DocumentManager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    #[Route('/users/{id}')]
    public function getUserById(DocumentManager $dm, Security $security, string $id)
    {
        $user = $dm->getRepository(User::class)->find($id);
        if ($user === null)
            throw new NotFoundHttpException('User not found.');
        $resource = new Item($user, new UserTransformer($security), 'user');
        $result = DefaultManager::getInstance()->createData($resource);
        return $this->json($result);
    }

    #[Route('/users/{id}/blogs')]
    public function getBlogsForUser(DocumentManager $dm, Security $security, string $id)
    {
        $user = $dm->getRepository(User::class)->find($id);
        if ($user === null)
            throw new NotFoundHttpException('User not found.');

        $blogs = $dm->createQueryBuilder(Blog::class)
            ->field('createdBy')->references($user)
            ->getQuery()
            ->execute();

        $resource = new Collection($blogs, new BlogTransformer($security), 'blogs');
        $result = DefaultManager::getInstance()->createData($resource);
        return $this->json($result);
    }
}
