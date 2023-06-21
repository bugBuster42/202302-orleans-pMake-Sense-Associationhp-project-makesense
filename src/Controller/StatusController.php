<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\SearchDecisionType;
use App\Repository\StatusRepository;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/status', name: 'status_')]
class StatusController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
        DecisionRepository $decisionRepository,
        StatusRepository $statusRepository,
        ?Status $status,
    ): Response {

        $form = $this->createForm(SearchDecisionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $status = $form->getData()['status'];

            $decisions = $decisionRepository->findDecision($search, $status);
            $statuses = $statusRepository->findAll();
        } else {
            $decisions = $decisionRepository->findAll();
            $statuses = $statusRepository->findAll();
        }

        return $this->render('status/index.html.twig', [
            'decisions' => $decisions, $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'statuses' => $statuses, $statusRepository->findAll(),
            'form' => $form,

        ]);
    }

    #[Route('/{id}', name: 'decision')]
    public function show(
        DecisionRepository $decisionRepository,
        StatusRepository $statusRepository,
        ?Status $status = null
    ): Response {
        return $this->render('status/index.html.twig', [
            'decisions' => $decisionRepository->findBy(['status' => $status], ['startDate' =>  'DESC']),
            'statuses' => $statusRepository->findAll(),
        ]);
    }
}
