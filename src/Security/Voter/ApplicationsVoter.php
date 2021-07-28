<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Applications;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class ApplicationsVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Applications;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /**@var User $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) return false;
        
        /**@var Applications $application */
        $application = $subject;
        // check if the application exists
        if (null === $application) return false;
        
        switch ($attribute) {
            case self::EDIT:
                return $application->getUser() === $user;
                break;
            case self::DELETE:
                return $application->getUser() === $user;
                break;
        }
        return false;
    }
}
