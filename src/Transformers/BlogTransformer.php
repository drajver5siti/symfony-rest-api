<?php

namespace App\Transformers;

use App\Documents\Blog;
use App\Documents\User;
use League\Fractal\TransformerAbstract;
use App\Transformers\PermissionTransformer;
use Symfony\Component\Security\Core\Security;

class BlogTransformer extends TransformerAbstract
{

    private $security;
    protected array $defaultIncludes = ['permissions'];
    protected array $availableIncludes = ['permissions'];

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function transform(Blog $blog)
    {
        // dd($blog);
        return [
            'id' => $blog->getId(),
            'title' => $blog->getTitle(),
            'body' => $blog->getBody(),
            'createdAt' => $blog->getDatePublished(),
            'isForAdults' => $blog->getIsForAdults(),
            'createdBy' => [
                'username' => $blog->getCreatedBy()->getUsername(),
                'id' => $blog->getCreatedBy()->getId()
            ],
        ];
    }

    public function includePermissions(Blog $blog)
    {
        $result =  $this->item($blog, new PermissionTransformer($this->security));
        // dd($result);
        return $result;
        // return [
        //     'canDelete' => ($this->security->isGranted('ROLE_ADMIN') || $user->getId() === $blog->getCreatedBy()->getId()),
        // ];
    }
}
