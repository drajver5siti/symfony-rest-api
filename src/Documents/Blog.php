<?php

namespace App\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document()]
class Blog
{

    #[ODM\Id(type: 'string')]
    private $id;

    #[ODM\Field(type: 'string')]
    private $title;

    #[ODM\Field(type: 'string')]
    private $body;

    #[ODM\Field(type: 'date')]
    private $datePublished;

    #[ODM\ReferenceOne(targetDocument: User::class, inversedBy: 'blogs')]
    private $createdBy;

    #[ODM\Field(type: 'bool')]
    private $isForAdults;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of datePublished
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * Set the value of datePublished
     *
     * @return  self
     */
    public function setDatePublished(\DateTime $datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * Get the value of createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of createdBy
     * @param User $createdBy
     * @return  self
     */
    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get the value of isForAdults
     */
    public function getIsForAdults(): bool
    {
        return $this->isForAdults ?? false;
    }

    /**
     * Set the value of isForAdults
     * 
     * @return  self
     */
    public function setIsForAdults(bool $isForAdults)
    {
        $this->isForAdults = $isForAdults;

        return $this;
    }
}
