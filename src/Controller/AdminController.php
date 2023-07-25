<?php

namespace App\Controller;

use App\Form\UserSearchType;
use App\Repository\UserRepository;
use App\Repository\DecisionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
#[IsGranted('ROLE_ADMIN')]

class AdminController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/user', name: 'user_index', methods: ['GET', 'POST'])]
    public function userIndex(UserRepository $userRepository, Request $request): Response
    {
        $form = $this->createForm(UserSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $users = $userRepository->searchUser($data['search']);
        } else {
            $users = $userRepository->findBy([], ['lastname' => 'ASC']);
        }
        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $users,
            'form' => $form,
        ]);
    }


    #[Route('/decision', name: 'decision_index', methods: ['GET', 'POST'])]
    public function decisionIndex(DecisionRepository $decisionRepository): Response
    {

        return $this->render('admin/admin_decision/index.html.twig', [
            'decisions' => $decisionRepository->findBy([], ['startDate' =>  'DESC']),
        ]);
    }
}
