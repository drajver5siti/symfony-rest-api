<?php

namespace App\Handlers;

use App\Documents\Blog;
use App\Managers\DefaultManager;
use App\Commands\EditBlogCommand;
use League\Fractal\Resource\Item;
use App\Transformers\BlogTransformer;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class EditBlogHandler
{

    private $dm;
    private $security;
    public function __construct(DocumentManager $dm, Security $security)
    {
        $this->dm = $dm;
        $this->security = $security;
    }

    public function handle(EditBlogCommand $command)
    {
        /**
         * @var Blog
         */
        $blog = $this->dm->getRepository(Blog::class)->find($command->getId());
        $title = $command->getTitle();
        $body = $command->getBody();

        if ($title)
            $blog->setTitle($title);

        if ($body)
            $blog->setBody($body);


        $this->dm->persist($blog);
        $this->dm->flush();

        // return new JsonResponse($blog, 200); // this return empty object ? ?? 
        $resource = new Item($blog, new BlogTransformer($this->security), 'blog');
        $result = DefaultManager::getInstance()->createData($resource);

        return new JsonResponse($result, 200);
    }
}
