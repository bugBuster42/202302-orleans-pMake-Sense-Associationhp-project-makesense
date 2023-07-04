<?php

namespace App\Controller;

use App\Form\SearchDecisionType;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/status', name: 'status_')]
class DecisionSearchController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
        DecisionRepository $decisionRepository,
    ): Response {

        $form = $this->createForm(SearchDecisionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];

            $decisions = $decisionRepository->findDecision($search, $form->getData()['status']);
        } else {
            $decisions = $decisionRepository->findAll();
        }

        return $this->render('status/index.html.twig', [
            'decisions' => $decisions, $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'form' => $form->createView(),

        ]);
    }
}
