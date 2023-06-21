<?php

namespace App\Controller;

use App\Entity\Status;
use App\Repository\CategoryRepository;
use App\Repository\StatusRepository;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/status', name: 'status_')]
class DecisionSearchController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        DecisionRepository $decisionRepository,
        StatusRepository $statusRepository,
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render('status/index.html.twig', [
            'decisions' => $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'statuses' => $statusRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
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
