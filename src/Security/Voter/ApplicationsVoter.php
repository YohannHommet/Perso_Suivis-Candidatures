<?php

namespace App\Security\Voter;

use App\Entity\Applications;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ApplicationsVoter extends Voter
{
    
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
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
        if (null === $application) return false;
        

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                // logic to determine if the user can VIEW
                $this->canView($application, $user);
                break;
            case self::EDIT:
                // logic to determine if the user can EDIT
                $this->canEdit($application, $user);
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                $this->canDelete($application, $user);
                break;
        }

        return false;
    }
    
    private function canView(Applications $application, User $user): bool
    {
        return $application->getUser() === $user;
    }

    private function canEdit(Applications $application, User $user): bool
    {
        return $application->getUser() === $user;
    }

    private function canDelete(Applications $application, User $user): bool
    {
        return $application->getUser() === $user;
    }

}
