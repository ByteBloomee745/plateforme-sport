<?php

namespace App\Controller;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/membre')]
class MembreController extends AbstractController
{
    #[Route('/new', name: 'app_membre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $membre = new Membre();
        $form = $this->createFormBuilder($membre)
            ->add('nomPrenom')
            ->add('dateNaissance')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipe_new');
        }

        return $this->render('membre/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
} 