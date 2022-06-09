<?php

namespace App\Commands;


class EditBlogCommand
{
    private ?string $title;
    private ?string $body;
    private $id;

    public function __construct($id, ?string $title, ?string $body)
    {
        $this->title = $title;
        $this->body = $body;
        $this->id = $id;
    }


    /**
     * Get the id of the blog you are currently editing.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string|null
    {
        return $this->title;
    }

    /**
     * Get the value of body
     */
    public function getBody(): string|null
    {
        return $this->body;
    }
}
