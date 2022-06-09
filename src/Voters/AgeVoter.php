<?php

namespace App\Voters;

use App\Documents\Blog;
use App\Documents\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AgeVoter extends Voter
{
    const VIEW_BLOG = 'VIEW_BLOG';
    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::VIEW_BLOG]))
            return false;

        if (!$subject instanceof Blog)
            return false;

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /**
         * @var Blog
         */
        $blog = $subject;

        /**
         * @var User
         */
        $user = $token->getUser();

        if (!$user instanceof User)
            return false;

        switch ($attribute) {
            case self::VIEW_BLOG:
                return $this->canView($user, $blog);
        }
        throw new \LogicException('This code should be unreachable.');
    }

    private function canView(User $user, Blog $blog)
    {
        if ($blog->getIsForAdults())
            return $user->getAge() >= 18;
        return true;
    }
}
