<?php

namespace App\Twig\Components;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('notification')]
final class NotificationComponent extends AbstractController
{
    use DefaultActionTrait;

    public function __construct(
        private NotificationRepository $notifRepository
    ) {
    }

    public function getNotifications(): array
    {
        return $this->notifRepository->findBy(['user' => $this->getUser()], ['id' => 'DESC'], limit: 10);
    }

    #[LiveAction]
    public function markAsRead(#[LiveArg] int $notificationId): Response
    {
        $notification = $this->notifRepository->find($notificationId);
        $notification->setIsRead(true);
        $this->notifRepository->save($notification, true);

        return $this->redirectToRoute('app_decision_show', [
            'id' => $notification->getDecision()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
