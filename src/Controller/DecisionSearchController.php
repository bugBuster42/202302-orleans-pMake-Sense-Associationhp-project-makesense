<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Form\SearchDecisionType;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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
            $category = $form->getData()['category'];

            $decisions = $decisionRepository->findDecision($search, $form->getData()['status'], $category);
        } else {
            $decisions = $decisionRepository->findAll();
        }

        return $this->render('status/index.html.twig', [
            'decisions' => $decisions, $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'form' => $form,

        ]);
    }

    #[Route('/mes-decisions', name: 'my_decision')]
    public function decision(
        Request $request,
        DecisionRepository $decisionRepository,
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(SearchDecisionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $status = $form->getData()['status'];
            $category = $form->getData()['category'];

            $decisions = $decisionRepository->findDecision($search, $status, $category, $user);
        } else {
            $decisions = $decisionRepository->findBy(['user' => $user], ['startDate' => 'DESC']);
        }

        return $this->render('status/myDecision.html.twig', [
            'decisions' => $decisions,
            'form' => $form,

        ]);
    }
}
