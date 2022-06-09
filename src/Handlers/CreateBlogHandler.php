<?php

namespace App\Handlers;

use App\Documents\Blog;
use App\Managers\DefaultManager;
use League\Fractal\Resource\Item;
use App\Commands\CreateBlogCommand;
use App\Documents\User;
use App\Transformers\BlogTransformer;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class CreateBlogHandler
{

    private $dm;
    private $security;
    public function __construct(DocumentManager $dm, Security $security)
    {
        $this->dm = $dm;
        $this->security = $security;
    }

    public function handle(CreateBlogCommand $command)
    {
        $blog = new Blog();
        $blog
            ->setTitle($command->getTitle())
            ->setBody($command->getBody())
            ->setCreatedBy($command->getCreatedBy())
            ->setDatePublished($command->getDatePublished())
            ->setIsForAdults($command->getIsForAdults());

        // dd($command->getCreatedBy());
        $this->dm->persist($blog);
        $this->dm->flush();

        $resource = new Item($blog, new BlogTransformer($this->security), 'blog');
        $result = DefaultManager::getInstance()->createData($resource);

        return new JsonResponse($result, 200);
    }
}
