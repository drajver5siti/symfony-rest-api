<?php

namespace App\Documents;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ODM\Document(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ODM\Id(type: 'string', strategy: 'auto')]
    private $id;

    #[ODM\Field(type: 'string')]
    private $username;

    #[ODM\Field(type: 'string')]
    private $password;

    #[ODM\Field(type: 'collection', nullable: false)]
    private $roles;

    #[ODM\Field(type: 'int')]
    private $age;

    #[ODM\ReferenceMany(targetDocument: Blog::class, cascade: ['persist'], orphanRemoval: true)]
    private $blogs;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }


    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of blogs
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    /**
     * @param Blog $blog
     * @return self
     */
    public function addBlog(Blog $blog): self
    {
        $this->blogs->add($blog);
        // $this->blogs = $blog;
        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->getUsername();
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials()
    {
    }
}
