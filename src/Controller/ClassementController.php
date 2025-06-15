<?php

namespace App\Controller;

use App\Entity\Classement;
use App\Entity\Competition;
use App\Entity\Sport;
use App\Entity\Membre;
use App\Service\ClassementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classement')]
final class ClassementController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ClassementService $classementService
    ) {
    }

    #[Route('/', name: 'app_classement_index')]
    public function index(Request $request): Response
    {
        $sportId = $request->query->get('sport');
        $competitionId = $request->query->get('competition');
        $membreId = $request->query->get('membre');

        $queryBuilder = $this->entityManager->getRepository(Classement::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.membre', 'm')
            ->leftJoin('c.competition', 'comp')
            ->leftJoin('comp.sport', 's')
            ->addSelect('m', 'comp', 's')
            ->orderBy('c.points', 'DESC')
            ->addOrderBy('c.victoires', 'DESC');

        if ($sportId) {
            $queryBuilder->andWhere('s.id = :sportId')
                ->setParameter('sportId', $sportId);
        }

        if ($competitionId) {
            $queryBuilder->andWhere('comp.id = :competitionId')
                ->setParameter('competitionId', $competitionId);
        }

        if ($membreId) {
            $queryBuilder->andWhere('m.id = :membreId')
                ->setParameter('membreId', $membreId);
        }

        $classements = $queryBuilder->getQuery()->getResult();

        // Get filter options
        $sports = $this->entityManager->getRepository(Sport::class)->findAll();
        $competitions = $this->entityManager->getRepository(Competition::class)->findAll();
        $membres = $this->entityManager->getRepository(Membre::class)->findAll();

        return $this->render('classement/index.html.twig', [
            'classements' => $classements,
            'sports' => $sports,
            'competitions' => $competitions,
            'membres' => $membres,
            'current_sport' => $sportId,
            'current_competition' => $competitionId,
            'current_membre' => $membreId,
        ]);
    }

    #[Route('/dashboard', name: 'app_classement_dashboard')]
    public function dashboard(): Response
    {
        // Statistiques générales
        $totalClassements = $this->entityManager->getRepository(Classement::class)->count([]);
        $totalCompetitions = $this->entityManager->getRepository(Competition::class)->count([]);
        $totalMembres = $this->entityManager->getRepository(Membre::class)->count([]);

        // Top 10 des meilleurs joueurs (tous sports confondus)
        $topJoueurs = $this->entityManager->getRepository(Classement::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.membre', 'm')
            ->leftJoin('c.competition', 'comp')
            ->leftJoin('comp.sport', 's')
            ->addSelect('m', 'comp', 's')
            ->orderBy('c.points', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        // Classements par sport
        $classementsParSport = [];
        $sports = $this->entityManager->getRepository(Sport::class)->findAll();
        
        foreach ($sports as $sport) {
            $classements = $this->entityManager->getRepository(Classement::class)
                ->createQueryBuilder('c')
                ->leftJoin('c.membre', 'm')
                ->leftJoin('c.competition', 'comp')
                ->leftJoin('comp.sport', 's')
                ->addSelect('m', 'comp', 's')
                ->where('s.id = :sportId')
                ->setParameter('sportId', $sport->getId())
                ->orderBy('c.points', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
            
            $classementsParSport[$sport->getNom()] = $classements;
        }

        return $this->render('classement/dashboard.html.twig', [
            'total_classements' => $totalClassements,
            'total_competitions' => $totalCompetitions,
            'total_membres' => $totalMembres,
            'top_joueurs' => $topJoueurs,
            'classements_par_sport' => $classementsParSport,
        ]);
    }

    #[Route('/new', name: 'app_classement_new')]
    public function new(Request $request): Response
    {
        // TODO: Ajouter la sécurité - accès par rôle Admin ou Coach uniquement
        $classement = new Classement();
        
        if ($request->isMethod('POST')) {
            $membreId = $request->request->get('membre_id');
            $competitionId = $request->request->get('competition_id');
            $points = $request->request->get('points');
            $victoires = $request->request->get('victoires');
            $defaites = $request->request->get('defaites');
            $nuls = $request->request->get('nuls');

            $membre = $this->entityManager->getRepository(Membre::class)->find($membreId);
            $competition = $this->entityManager->getRepository(Competition::class)->find($competitionId);

            if ($membre && $competition) {
                $classement->setMembre($membre);
                $classement->setCompetition($competition);
                $classement->setPoints($points ?: 0);
                $classement->setVictoires($victoires ?: 0);
                $classement->setDefaites($defaites ?: 0);
                $classement->setNuls($nuls ?: 0);

                $this->entityManager->persist($classement);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_classement_index');
            }
        }

        $membres = $this->entityManager->getRepository(Membre::class)->findAll();
        $competitions = $this->entityManager->getRepository(Competition::class)->findAll();

        return $this->render('classement/new.html.twig', [
            'classement' => $classement,
            'membres' => $membres,
            'competitions' => $competitions,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classement_edit')]
    public function edit(Request $request, Classement $classement): Response
    {
        // TODO: Ajouter la sécurité - accès par rôle Admin ou Coach uniquement
        
        if ($request->isMethod('POST')) {
            $points = $request->request->get('points');
            $victoires = $request->request->get('victoires');
            $defaites = $request->request->get('defaites');
            $nuls = $request->request->get('nuls');

            $classement->setPoints($points ?: 0);
            $classement->setVictoires($victoires ?: 0);
            $classement->setDefaites($defaites ?: 0);
            $classement->setNuls($nuls ?: 0);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_classement_index');
        }

        return $this->render('classement/edit.html.twig', [
            'classement' => $classement,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_classement_delete', methods: ['POST'])]
    public function delete(Request $request, Classement $classement): Response
    {
        // TODO: Ajouter la sécurité - accès par rôle Admin ou Coach uniquement
        
        if ($this->isCsrfTokenValid('delete'.$classement->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($classement);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_classement_index');
    }
}

