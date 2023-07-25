<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Decision;
use App\Entity\Notification;
use App\Form\CommentType;
use App\Form\DecisionType;
use Symfony\Component\Mime\Email;
use App\Repository\CommentRepository;
use App\Repository\DecisionRepository;
use App\Repository\VoteRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\WorkflowAdvancement;

#[Route('/decision')]
class DecisionController extends AbstractController
{
    #[Route('/', name: 'app_decision_index', methods: ['GET', 'POST'])]
    public function index(DecisionRepository $decisionRepository): Response
    {

        return $this->render('admin/admin_decision/index.html.twig', [
            'decisions' => $decisionRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'app_decision_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        DecisionRepository $decisionRepository,
        NotificationRepository $notifRepository,
        MailerInterface $mailer
    ): Response {

        $decision = new Decision();
        $form = $this->createForm(DecisionType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decision->setUser($this->getUser());
            $decisionRepository->save($decision, true);

            $this->addFlash('success', 'La nouvelle décision a bien été créée.');

            $expertUsers = $decision->getExpertUsers();
            foreach ($expertUsers as $user) {
                $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to($user->getEmail())
                    ->subject('(Makesense) nouvelle décision')
                    ->html($this->renderView('decision/newEmailExpert.html.twig', ['decision' => $decision,]));
                $mailer->send($email);
                $notif = new Notification();
                $notif->setDecision($decision);
                $notif->setUser($user);
                $notif->setMessage($decision->getTitle());
                $notif->setIsRead(false);
                $notifRepository->save($notif, true);
            }
            $impactedUsers = $decision->getImpactedUsers();
            foreach ($impactedUsers as $user) {
                $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to($user->getEmail())
                    ->subject('(Makesense) nouvelle décision')
                    ->html($this->renderView('decision/newEmailImpacted.html.twig', ['decision' => $decision]));
                $mailer->send($email);
                $notif = new Notification();
                $notif->setDecision($decision);
                $notif->setUser($user);
                $notif->setMessage($decision->getTitle());
                $notif->setIsRead(false);
                $notifRepository->save($notif, true);
            }

            return $this->redirectToRoute('status_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('decision/new.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/archive', name: 'app_archive')]
    public function archive(DecisionRepository $decisionRepository): Response
    {
        return $this->render('decision/archive.html.twig', [
            'decisions' => $decisionRepository->findall(),
        ]);
    }

    #[Route('/change/{id}/{toStatus}', name: 'app_change', methods: ['POST'])]
    public function change(
        Decision $decision,
        string $toStatus,
        DecisionRepository $decisionRepository,
        WorkflowInterface $decisionStateMachine,
    ): Response {

        if ($toStatus && $decisionStateMachine->can($decision, $toStatus)) {
            $decisionStateMachine->apply($decision, $toStatus);
            $decisionRepository->save($decision, true);
        }

        return $this->redirectToRoute('app_decision_show', ['id' => $decision->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_decision_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Decision $decision, CommentRepository $commentRepository): Response
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setDecision($decision);
            $commentRepository->save($comment, true);

            $this->addFlash('success', 'Votre commentaire a bien été ajouté.');

            return $this->redirectToRoute('app_decision_show', ['id' => $decision->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('decision/show.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_decision_edit', methods: ['GET', 'POST'])]
    #[IsGranted(
        attribute: new Expression('user === subject'),
        subject: new Expression('args["decision"].getUser()'),
    )]
    public function edit(
        Request $request,
        Decision $decision,
        DecisionRepository $decisionRepository,
        WorkflowAdvancement $workflowAdvancement
    ): Response {
        $workflowName = $workflowAdvancement->stepStatus($decision);

        $decision->setUser($this->getUser());
        $form = $this->createForm(DecisionType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decision = $form->getData();

            $decisionRepository->save($decision, true);

            $this->addFlash('success', 'La décision a bien été modifiée.');

            return $this->redirectToRoute('status_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('decision/edit.html.twig', [
            'decision' => $decision,
            'form' => $form,
            'workflowName' => $workflowName,
        ]);
    }

    #[Route('/{id}', name: 'app_decision_delete', methods: ['POST'])]
    public function delete(Request $request, Decision $decision, DecisionRepository $decisionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $decision->getId(), $request->request->get('_token'))) {
            $decisionRepository->remove($decision, true);
            $this->addFlash('success', 'La décision a bien été supprimée.');
        }

        return $this->redirectToRoute('status_home', [], Response::HTTP_SEE_OTHER);
    }
}
