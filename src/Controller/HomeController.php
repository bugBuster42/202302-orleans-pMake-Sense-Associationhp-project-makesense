<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Form\DecisionType;
use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'page')]
    public function index(DecisionRepository $decisionRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'decisions' => $decisionRepository->findBy([], ['id' =>  'DESC'], 3, 0),
        ]);
    }
}
