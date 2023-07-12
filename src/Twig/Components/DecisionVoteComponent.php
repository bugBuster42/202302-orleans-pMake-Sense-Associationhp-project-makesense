<?php

namespace App\Twig\Components;

use App\Entity\Vote;
use App\Entity\Decision;
use App\Repository\VoteRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('decisionVote')]
final class DecisionVoteComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Decision $decision;

    #[LiveProp]
    public bool $hasVoted = false;

    public function __construct(private VoteRepository $voteRepository)
    {
    }

    #[PostMount]
    public function postMount(): void
    {
        $this->checkHasVoted();
    }

    public function checkHasVoted(): void
    {
        $vote = $this->voteRepository->findOneBy(['user' => $this->getUser(), 'decision' => $this->decision]);
        $this->hasVoted = $vote !== null;
    }
    #[LiveAction]
    public function voted(#[LiveArg] string $direction): void
    {
        if (!$this->hasVoted) {
            $vote = new Vote();
            $vote->setUser($this->getUser());
            $vote->setDecision($this->decision);
            if ('up' === $direction) {
                $vote->setVoting(1);
            } else {
                $vote->setVoting(-1);
            }
            $this->voteRepository->save($vote, true);
        }
        $this->hasVoted = true;
    }
}
