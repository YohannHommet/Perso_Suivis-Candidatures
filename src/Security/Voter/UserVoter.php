<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;


class UserVoter extends Voter
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ["access"])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /**@var UserInterface $user */
        $user = $token->getUser();
        /**@var \App\Entity\User $userSubject */
        $userSubject = $subject;
        
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) return false;
        if (!$this->security->isGranted('ROLE_USER')) return false;
        if (!$user === $userSubject) return false;
        
        switch ($attribute) {
            case "access":
                if($userSubject->isVerified() === true) return true;
            else return false;
            break;
        }
            
        return false;
    }        
}
