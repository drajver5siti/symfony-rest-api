<?php

namespace App\Transformers;

use App\Documents\User;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Security\Core\Security;

class UserTransformer extends TransformerAbstract
{

    protected array $availableIncludes = [
        'blogs'
    ];

    protected array $defaultIncludes = [];

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function transform(User $user)
    {

        $result = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'age' => (int) $user->getAge(),
        ];


        if ($this->security->isGranted('ROLE_ADMIN'))
            $result['roles'] = $user->getRoles();

        return $result;
    }

    public function includeBlogs(User $user)
    {
        $blogs = $user->getBlogs()->toArray();

        // dd($blogs);
        return $this->collection($blogs, new BlogTransformer($this->security));
    }
}
//