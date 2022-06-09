<?php

namespace App\Transformers;

use App\Documents\Blog;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Security\Core\Security;

class PermissionTransformer extends TransformerAbstract
{
    private $security;
    public function __construct(?Security $security)
    {
        $this->security = $security;
    }

    public function transform(Blog $blog)
    {
        /**
         * @var User
         */
        $user = $this->security->getUser();
        $result =  [
            'canDelete' => ($this->security->isGranted('ROLE_ADMIN') || $user->getId() === $blog->getCreatedBy()->getId()),
        ];
        // dd($result);
        return $result;
    }
}
