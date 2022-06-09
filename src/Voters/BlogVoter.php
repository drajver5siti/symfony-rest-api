<?php

namespace App\Voters;

use App\Documents\Blog;
use App\Documents\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class BlogVoter extends Voter
{

    const EDIT_BLOG = "EDIT_BLOG";
    const DELETE_BLOG = "DELETE_BLOG";
    const VIEW_BLOG = "VIEW_BLOG";
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // I cannot vote
        if (!in_array($attribute, [self::EDIT_BLOG, self::DELETE_BLOG, self::VIEW_BLOG]))
            return false;

        // I cannot vote
        if (!$subject instanceof Blog)
            return false;

        return true;
    }

    // I can vote, do i vote true or false ? 
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // $user doesn't exist, not logged in.
        if (!$user instanceof User)
            return false;

        /**
         * @var Blog
         */
        $blog = $subject;

        switch ($attribute) {
            case self::EDIT_BLOG:
                return $this->canEdit($user, $blog);
            case self::DELETE_BLOG:
                return $this->canDelete($user, $blog);
            case self::VIEW_BLOG:
                return $this->canView($user, $blog);
        }
        throw new \LogicException('This code should be unreachable !');
    }

    private function canEdit(User $user, Blog $blog)
    {
        return $this->security->isGranted('ROLE_ADMIN') || $user->getId() === $blog->getCreatedBy()->getId();
    }

    private function canDelete(User $user, Blog $blog)
    {
        return $this->canEdit($user, $blog);
    }

    private function canView(User $user, Blog $blog)
    {
        return true;
    }
}
