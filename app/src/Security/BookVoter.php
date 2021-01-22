<?php

namespace App\Security;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class BookVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on `Book` objects
        if (!$subject instanceof Book) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // you know $subject is a Book object, thanks to `supports()`
        /** @var Book $book */
        $book = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($book, $user);
            case self::DELETE:
                return $this->canDelete($book, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Book $book, User $user)
    {
        return $user === $book->getCreator();
    }

    private function canDelete(Book $book, User $user)
    {
        return $this->canEdit($book, $user);
    }
}