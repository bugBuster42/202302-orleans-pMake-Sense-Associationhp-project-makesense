<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('role')]
final class RoleComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public User $user;

    #[LiveAction]
    public function updateRole(#[LiveArg] string $newRole, UserRepository $userRepository): void
    {
        $user = $this->user;
        $user->setRoles([$newRole]);
        $userRepository->save($user, true);
    }
}
