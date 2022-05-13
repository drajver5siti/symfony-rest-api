<?php

namespace App\Transformers;

use App\Documents\User;
use App\Exceptions\InvalidParamsException;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Security\Core\Security;

class UserTransformer extends TransformerAbstract
{

    protected array $availableIncludes = [
        'blogs'
    ];

    protected array $defaultIncludes = [];

    private $validParams = ['limit'];
    private $security;

    public function __construct(?Security $security)
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

    public function includeBlogs(User $user, ParamBag $params)
    {
        $blogs = $user->getBlogs();

        $limit = htmlspecialchars($_GET['limit'] ?? null);



        // dd($_GET['include']);
        if (count($params->getIterator()) > 0) {

            dd(null);
            // shape data according to the params
            $usedParams = array_keys(iterator_to_array($params));
            $invalidParams = array_diff($usedParams, $this->validParams);
            // invalidParams that were sent and are not valid
            if ($invalidParams) {
                throw new InvalidParamsException(400, "Invalid Params");
            }

            // list($limit, $offset) = $params->get('limit');
            $blogs = $user
                ->getBlogs();
        }
        return $this->collection($blogs, new BlogTransformer);
        // https://fractal.thephpleague.com/pagination/
    }
}
//