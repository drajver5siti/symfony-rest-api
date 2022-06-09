<?php

namespace App\Controller;

use App\Documents\Blog;
use App\Documents\User;
use App\Managers\DefaultManager;
use League\Tactician\CommandBus;
use League\Fractal\Resource\Item;
use App\Commands\CreateBlogCommand;
use App\Commands\EditBlogCommand;
use App\Transformers\BlogTransformer;
use App\Constraints\EditBlogConstraint;
use App\Exceptions\ValidationException;
use League\Fractal\Resource\Collection;
use App\Exceptions\InvalidDataException;
use App\Constraints\CreateBlogConstraint;
use App\Exceptions\UnauthorizedException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/api/blogs')]
class BlogsController extends AbstractController
{
    private $repo;
    private $dm;
    private $security;
    public function __construct(DocumentManager $dm, Security $security)
    {
        $this->dm = $dm;
        $this->repo = $dm->getRepository(Blog::class);
        $this->security = $security;
    }

    #[Route('/', methods: ['POST'])]
    public function create(Request $request, CommandBus $bus, Security $security, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);

        $errors = $validator->validate($data, CreateBlogConstraint::get());
        if ($errors->count())
            throw new ValidationException(400, $errors);

        $command = new CreateBlogCommand($data['title'], $data['body'], $data['isForAdults'], new \DateTime(), $security->getUser());
        return $bus->handle($command);
    }

    #[Route('/{id}', methods: ['GET'], defaults: ['id' => null])]
    public function show(?string $id)
    {
        if ($id) {
            $blog = $this->repo->findOneBy(['id' => $id]);
            if ($blog == null)
                throw new NotFoundHttpException('Resource not found.');

            $this->denyAccessUnlessGranted('VIEW_BLOG', $blog);
            $resource = new Item($blog, new BlogTransformer($this->security), 'blog');
            $result = DefaultManager::getInstance()->createData($resource);
            return $this->json($result);
        } else {
            // $blogs = $this->repo->findAll();
            $blogs = $this->dm->createQueryBuilder(Blog::class)
                ->sort('datePublished', 'desc')
                ->getQuery()
                ->execute();


            $resource = new Collection($blogs, new BlogTransformer($this->security), 'blogs');
            $result = DefaultManager::getInstance()->createData($resource);
            return $this->json($result);
        }
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function edit(Request $request, ValidatorInterface $validator, CommandBus $bus, string $id)
    {
        /**
         * @var Blog
         */
        $blog = $this->repo->findOneBy(['id' => $id]);
        if ($blog == null)
            throw new NotFoundHttpException('Resource not found.');

        $this->denyAccessUnlessGranted('EDIT_BLOG', $blog);

        $data = json_decode($request->getContent(), true);

        $errors = $validator->validate($data, EditBlogConstraint::get());

        if ($errors->count())
            throw new ValidationException(400, $errors);

        $command = new EditBlogCommand($blog->getId(), $data['title'] ?? null, $data['body'] ?? null);
        return $bus->handle($command);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(DocumentManager $dm, string $id)
    {
        $blog = $this->repo->findOneBy(['id' => $id]);

        if ($blog == null)
            throw new NotFoundHttpException('Resource not found');

        $this->denyAccessUnlessGranted('DELETE_BLOG', $blog);

        $dm->remove($blog);
        $dm->flush();
        return new JsonResponse([
            'message' => 'Post Deleted',
            'id' => $id,
        ], 200);
    }
}
