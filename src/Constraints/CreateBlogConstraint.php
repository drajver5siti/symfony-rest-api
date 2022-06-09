<?php

namespace App\Constraints;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;

class CreateBlogConstraint
{
    public static function get(): Collection
    {
        $constraints = new Assert\Collection([
            'fields' => [
                'title' => new Assert\Required([
                    'constraints' => [
                        new Assert\NotBlank(message: 'Blog title cannot be blank.'),
                        new Assert\Length([
                            'min' => 5,
                            'max' => 40,
                            'minMessage' => 'Title must be over 5 characters.',
                            'maxMessage' => 'Title cannot be over 40 characters',
                        ])
                    ]
                ]),
                'body' => new Assert\Required([
                    'constraints' => [
                        new Assert\NotBlank(message: 'Blog body cannot be blank.'),
                        new Assert\Length([
                            'min' => 30,
                            'minMessage' => 'Blog body must be over 30 characters.'
                        ])
                    ]
                ]),
                'isForAdults' => new Assert\Required([
                    'constraints' => [
                        new Assert\Type([
                            'type' => 'bool',
                            'message' => 'isForAdults field must be boolean.'
                        ])
                    ]
                ])
            ],
            'missingFieldsMessage' => "Field {{ field }} is missing.",
        ]);

        return $constraints;
    }
}
