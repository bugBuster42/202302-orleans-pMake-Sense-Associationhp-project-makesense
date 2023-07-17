<?php

namespace App\Service;

use App\Entity\Decision;

class WorkflowAdvancement
{
    public const FIRST_PERCENTAGE = 70 / 100;

    public const CONFLICT_PERCENTAGE = 50 / 100;

    public const MIN_VOTE = 20;

    /** @SuppressWarnings(PHPMD.CyclomaticComplexity) */
    public function stepStatus(Decision $decision): ?string
    {
        $workflowName = null;
        if (
            $decision->getCurrentPlace() === 'opened' && $decision->getPositiveVote() >=
            count($decision->getVotes()) * self::FIRST_PERCENTAGE
            && count($decision->getVotes()) > self::MIN_VOTE
        ) {
            $workflowName = 'to_decision_opened_accepted';
        } elseif (
            $decision->getCurrentPlace() === 'opened' && $decision->getNegativeVote() >=
            count($decision->getVotes()) * self::FIRST_PERCENTAGE
            && count($decision->getVotes()) > self::MIN_VOTE
        ) {
            $workflowName = 'to_decision_opened_refused';
        } elseif (
            $decision->getCurrentPlace() === 'opened' && $decision->getPositiveVote() <=
            count($decision->getVotes()) * self::FIRST_PERCENTAGE
            && $decision->getNegativeVote() <= count($decision->getVotes()) * self::FIRST_PERCENTAGE
            && count($decision->getVotes()) > self::MIN_VOTE
        ) {
            $workflowName = 'to_decision_opened_conflict';
        } elseif ($decision->getCurrentPlace() === 'accepted') {
            $workflowName = 'to_accepted_ended';
        } elseif ($decision->getCurrentPlace() === 'refused') {
            $workflowName = 'to_refused_ended';
        } elseif ($decision->getCurrentPlace()  === 'conflict') {
            $workflowName = 'to_conflict_modified';
        } elseif (
            $decision->getPositiveVote() >= count($decision->getVotes()) * self::CONFLICT_PERCENTAGE
            && count($decision->getVotes()) > self::MIN_VOTE
        ) {
            $workflowName = 'to_modified_accepted';
        } elseif (
            $decision->getNegativeVote() >= count($decision->getVotes()) * self::CONFLICT_PERCENTAGE
            && count($decision->getVotes()) > self::MIN_VOTE
        ) {
            $workflowName = 'to_modified_refused';
        }
        return $workflowName;
    }
}
