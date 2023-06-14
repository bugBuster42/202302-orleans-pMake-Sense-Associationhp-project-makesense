<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'page')]
    public function index(DecisionRepository $decisionRepository, StatusRepository $statusRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'decisions' => $decisionRepository->findBy([], ['startDate' =>  'DESC']),
            'statuses' => $statusRepository->findAll(),
        ]);
    }
}
