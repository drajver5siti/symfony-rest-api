<?php

namespace App\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document()]
class Job
{

    #[ODM\Id(type: 'string')]
    private $id;

    #[ODM\Field(type: 'string')]
    private $title;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
