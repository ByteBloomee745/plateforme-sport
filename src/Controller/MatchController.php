<?php

namespace App\Controller;

use App\Entity\MatchEntity;
use App\Form\MatchType;
use App\Service\ClassementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MatchController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ClassementService $classementService
    ) {
    }

    #[Route("/match/new", name: "app_match_new")]
    public function new(Request $request): Response
    {
        $match = new MatchEntity();
        $form = $this->createForm(MatchType::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($match);
            $this->entityManager->flush();

            // Logic for updating classement after match result
            $scoreA = $match->getScoreA();
            $scoreB = $match->getScoreB();

            if ($scoreA > $scoreB) {
                $resultA = 'victoire';
                $resultB = 'defaite';
            } elseif ($scoreA < $scoreB) {
                $resultA = 'defaite';
                $resultB = 'victoire';
            } else {
                $resultA = $resultB = 'nul';
            }

            // Assuming you have a way to get members of EquipeA and EquipeB
            // This part needs to be adapted based on your actual entity relationships
            // For now, I'll leave a placeholder for fetching members
            // $membresA = $this->entityManager->getRepository(Membership::class)->findBy(['equipe' => $match->getEquipeA()]);
            // $membresB = $this->entityManager->getRepository(Membership::class)->findBy(['equipe' => $match->getEquipeB()]);

            // foreach ($membresA as $mA) {
            //     $this->classementService->mettreAJourClassement(
            //         $mA->getMembre(),
            //         $match->getCompetition(),
            //         $resultA
            //     );
            // }

            // foreach ($membresB as $mB) {
            //     $this->classementService->mettreAJourClassement(
            //         $mB->getMembre(),
            //         $match->getCompetition(),
            //         $resultB
            //     );
            // }

            return $this->redirectToRoute('app_match_index'); // Assuming an index route for matches
        }

        return $this->render('match/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/match', name: 'app_match_index')]
    public function index(): Response
    {
        return $this->render('match/index.html.twig', [
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MatchController.php',
        ]);
    }
}
