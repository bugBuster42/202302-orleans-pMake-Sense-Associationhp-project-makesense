<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Decision;
use App\Form\SearchDecisionType;
use App\Repository\StatusRepository;
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
        ?Status $status
    ): Response {

        $form = $this->createForm(SearchDecisionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];

            $decisions = $decisionRepository->findDecision($search, $status);
        } else {
            $decisions = $decisionRepository->findAll();
        }

        return $this->render('status/index.html.twig', [
            'decisions' => $decisions, $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'form' => $form->createView(),

        ]);
    }

    #[Route('decision', name: 'my_decision')]
    // #[IsGranted(
    //     attribute: new Expression('user === subject'),
    //     subject: new Expression('args["decision"].getUser()'),
    // )]
    public function decision(
        Request $request,
        DecisionRepository $decisionRepository,
        ?Status $status
    ): Response {

        $user = $this->getUser();
        $form = $this->createForm(SearchDecisionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];

            $decisions = $decisionRepository->findMyDecision($search, $status, $user);
        } else {
            $decisions = $decisionRepository->findBy(['user' => $user], ['startDate' => 'DESC']);
        }

        return $this->render('status/myDecision.html.twig', [
            'decisions' => $decisions,
            'form' => $form->createView(),

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
