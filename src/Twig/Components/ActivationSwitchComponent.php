<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

#[AsLiveComponent('activationSwitch')]
final class ActivationSwitchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public User $user;

    #[LiveAction]
    public function toggleActivation(UserRepository $userRepository): void
    {
        $user = $this->user;
        $user->setIsActivated(!$user->isIsActivated());
        $userRepository->save($user, true);
    }
}
