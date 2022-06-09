<?php

namespace App\Constraints;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;

class RegisterUserConstraint
{


    public static function get(): Collection
    {
        $constraints = new Assert\Collection([
            'fields' => [
                'username' => new Assert\Required([
                    'constraints' => [
                        new Assert\Length([
                            'max' => 20,
                            'min' => 3,
                            'maxMessage' => 'Username too long ( 20 characters maximum ).',
                            'minMessage' => 'Username too short ( 3 characters minimum ).'
                        ]),
                        new Assert\Type([
                            'type' => 'string',
                            'message' => 'Username must be a string.'
                        ]),
                        new Assert\Regex([
                            "pattern" => "/^[a-z]*[0-9]*_{0,1}$/i",
                            "message" => "Username must start with a letter, can contain letters, numbers and one underscore."
                        ])
                    ],

                ]),

                'password' => new Assert\Required([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 7,
                            'minMessage' => 'Password too short ( 7 characters minimum ).',
                        ]),
                    ],

                    // 'groups' => ['USER_REGISTER']
                ]),

                'age' => new Assert\Required([
                    'constraints' => [
                        new Assert\NotBlank(message: 'Age field cannot be blank.'),
                        new Assert\Type([
                            'type' => 'integer',
                            'message' => 'Age must be a number.',
                        ]),
                        new Assert\GreaterThanOrEqual([
                            'value' => 15,
                            'message' => 'You must be 15 or over.'
                        ])
                    ],

                    // 'groups' => ['USER_REGISTER'],
                ]),
            ],
            'missingFieldsMessage' => "Field {{ field }} is missing.",
        ]);

        return $constraints;
    }
}
