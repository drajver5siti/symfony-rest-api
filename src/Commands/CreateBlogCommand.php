<?php

namespace App\Commands;

use App\Documents\User;

class CreateBlogCommand
{
    private string $title;
    private string $body;
    private bool $isForAdults;
    private \DateTime $datePublished;
    private User $createdBy;


    public function __construct(string $title, string $body, bool $isForAdults, \DateTime $datePublished, User $createdBy)
    {
        $this->title = $title;
        $this->body = $body;
        $this->datePublished = $datePublished;
        $this->createdBy = $createdBy;
        $this->isForAdults = $isForAdults;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get the value of datePublished
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }



    /**
     * Get the value of createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Get the value of isForAdults
     */
    public function getIsForAdults()
    {
        return $this->isForAdults;
    }
}
