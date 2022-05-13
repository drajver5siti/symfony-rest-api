<?php

namespace App\Transformers;

use App\Documents\Blog;
use DateTime;
use League\Fractal\TransformerAbstract;

class BlogTransformer extends TransformerAbstract
{
    public function transform(Blog $blog)
    {
        return [
            'id' => $blog->getId(),
            'title' => $blog->getTitle(),
            'body' => $blog->getBody(),
            'createdAt' => $blog->getDatePublished(),
            'createdBy' => $blog->getCreatedBy(),
        ];
    }
}
