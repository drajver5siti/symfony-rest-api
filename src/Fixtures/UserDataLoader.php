<?php

namespace App\Fixtures;

use App\Documents\Blog;
use App\Documents\Job;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Documents\User;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;

class UserDataLoader extends Fixture
{
    public function __construct()
    {
    }

    private function loadUsers(ObjectManager $manager)
    {
        $USERS = [
            [
                "username" => "ivanpavlovski",
                "fullname" => "Ivan Pavlovski",
                "email" => "ivan.pavlovskii@outlook.com",
                "age" => 20,
            ],
            [
                "username" => "filippavlovski",
                "fullname" => "Filip Pavlovski",
                "email" => "filip.pavlovski@gmail.com",
                "age" => 17,
            ]
        ];

        $user = new User();
        $user
            ->setUsername("ivanpavlovski")
            ->setPassword("test")
            ->setAge(20);

        $this->addReference('user', $user);
        $this->loadBlogs($manager);
        $user->addBlog($this->getReference('blog'));
        $manager->persist($user);
    }

    private function loadBlogs(ObjectManager $manager)
    {
        $blog = new Blog();
        $blog
            ->setTitle('How i got into google')
            ->setBody('Text text text')
            ->setDatePublished(new \DateTime())
            ->setCreatedBy($this->getReference('user'));

        $this->addReference('blog', $blog);
        $manager->persist($blog);
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        // $this->loadBlogs($manager);

        $manager->flush();
    }
}
