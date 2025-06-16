<?php

namespace App\Controller;

use App\Entity\Entrainement;
use App\Form\EntrainementForm;
use App\Repository\EntrainementRepository;
use App\Repository\EquipeRepository;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entrainement')]
final class EntrainementController extends AbstractController
{
    #[Route(name: 'app_entrainement_index', methods: ['GET'])]
    public function index(Request $request, EntrainementRepository $entrainementRepository, EquipeRepository $equipeRepository, MembreRepository $membreRepository): Response
    {
        $equipeId = $request->query->get('equipe');
        $coachId = $request->query->get('coach');
        $equipes = $equipeRepository->findAll();
        $coachs = $membreRepository->findAll();
        $qb = $entrainementRepository->createQueryBuilder('e')
            ->leftJoin('e.equipe', 'eq')
            ->addSelect('eq')
            ->leftJoin('e.coach', 'c')
            ->addSelect('c');
        if ($equipeId) {
            $qb->andWhere('eq.id = :equipeId')->setParameter('equipeId', $equipeId);
        }
        if ($coachId) {
            $qb->andWhere('c.id = :coachId')->setParameter('coachId', $coachId);
        }
        $entrainements = $qb->getQuery()->getResult();
        return $this->render('entrainement/index.html.twig', [
            'entrainements' => $entrainements,
            'equipes' => $equipes,
            'coachs' => $coachs,
            'current_equipe' => $equipeId,
            'current_coach' => $coachId,
        ]);
    }

    #[Route('/new', name: 'app_entrainement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entrainement = new Entrainement();
        $form = $this->createForm(EntrainementForm::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entrainement);
            $entityManager->flush();

            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entrainement/new.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entrainement_show', methods: ['GET'])]
    public function show(Entrainement $entrainement): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'entrainement' => $entrainement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entrainement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entrainement $entrainement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntrainementForm::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entrainement/edit.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entrainement_delete', methods: ['POST'])]
    public function delete(Request $request, Entrainement $entrainement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrainement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entrainement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
    }
}
