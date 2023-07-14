<?php

namespace App\Service;

use App\Entity\Decision;

class WorkflowAdvancement
{
    public const FIRST_PERCENTAGE = 70 / 100;

    public const CONFLICT_PERCENTAGE = 50 / 100;

    public function firstStepStatus(Decision $decision): ?string
    {
        $workflowName = null;
        switch ($workflowName) {
            case $decision->getPositiveVote() <= count($decision->getVotes()) * self::FIRST_PERCENTAGE
                or count($decision->getVotes()) < 20:
                $workflowName = 'to_decision_opened_accepted';
                break;
            case $decision->getNegativeVote() <= count($decision->getVotes()) * self::FIRST_PERCENTAGE
                or count($decision->getVotes()) < 20:
                $workflowName = 'to_decision_opened_refused';
                break;
            case $decision->getPositiveVote() >= count($decision->getVotes()) * self::FIRST_PERCENTAGE
                and $decision->getNegativeVote() >= count($decision->getVotes()) * self::FIRST_PERCENTAGE
                or count($decision->getVotes()) < 20:
                $workflowName = 'to_decision_opened_conflict';
                break;
        }
        return $workflowName;
    }
    public function secondStepStatus(Decision $decision): ?string
    {
        $workflowStatus = $decision->getCurrentPlace();
        switch ($workflowStatus) {
            case $decision->getCurrentPlace() === 'accepted':
                $workflowStatus = 'to_accepted_ended';
                break;
            case $decision->getCurrentPlace() === 'refused':
                $workflowStatus = 'to_refused_ended';
                break;
            case $decision->getCurrentPlace() === 'conflict':
                $workflowStatus = 'to_conflict_modified';
                break;
        }
        return $workflowStatus;
    }
    public function conflictStepStatus(Decision $decision): ?string
    {
        $workflowConflict = null;
        switch ($workflowConflict = $decision->getCurrentPlace() === 'modified') {
            case $decision->getPositiveVote() >= count($decision->getVotes()) * self::CONFLICT_PERCENTAGE
                or count($decision->getVotes()) < 20:
                $workflowConflict = 'to_modified_accepted';
                break;
            case $decision->getNegativeVote() >= count($decision->getVotes()) * self::CONFLICT_PERCENTAGE
                or count($decision->getVotes()) < 20:
                $workflowConflict = 'to_modified_refused';
                break;
        }
        return $workflowConflict;
    }
}
