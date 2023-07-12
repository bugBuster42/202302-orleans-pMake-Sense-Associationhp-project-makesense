<?php

namespace App\Twig\Components;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('activationSwitch')]
final class ActivationSwitchComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public User $user;

    #[LiveAction]
    public function toggleActivation(UserRepository $userRepository, MailerInterface $mailer): void
    {
        $user = $this->user;
        $user->setIsActivated(!$user->isIsActivated());

        $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to('thomas@gmail.com')
            ->subject('MAKE SENSE a hate de connaitre vos idées, votre compte est activé!!')
            ->html($this->renderView('mail/activateUserEmail.html.twig', ['user' => $user]));

        $mailer->send($email);

        $userRepository->save($user, true);
    }
}
