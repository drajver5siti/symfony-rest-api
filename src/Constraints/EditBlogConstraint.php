<?php

namespace App\Constraints;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints as Assert;


class EditBlogConstraint
{
    public static function get(): Collection
    {
        return new Assert\Collection([
            'fields' => [
                'title' => new Assert\Optional([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 5,
                            'max' => 40,
                            'minMessage' => 'Title must be over 5 characters.',
                            'maxMessage' => 'Title cannot be over 40 characters',
                        ])
                    ]
                ]),
                'body' => new Assert\Optional([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 30,
                            'minMessage' => 'Blog body must be over 30 characters.'
                        ])
                    ]
                ]),
                'isForAdults' => new Assert\Optional([
                    'constraints' => [
                        new Assert\Type([
                            'type' => 'bool',
                            'message' => 'isForAdults must be a boolean.'
                        ])
                    ]
                ])
            ],
        ]);
    }
}
