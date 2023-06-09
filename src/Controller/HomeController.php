<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DecisionRepository $decisionRepository, StatusRepository $statusRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'decisions' => $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'statuses' => $statusRepository->findAll(),
        ]);
    }
}
