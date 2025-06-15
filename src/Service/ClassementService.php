<?php

namespace App\Service;

use App\Entity\Classement;
use App\Entity\Competition;
use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;

class ClassementService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function mettreAJourClassement(Membre $membre, Competition $competition, string $resultat): void
    {
        $classement = $this->entityManager->getRepository(Classement::class)->findOneBy([
            'membre' => $membre,
            'competition' => $competition,
        ]);

        if (!$classement) {
            $classement = new Classement();
            $classement->setMembre($membre);
            $classement->setCompetition($competition);
            $classement->setPoints(0);
            $classement->setVictoires(0);
            $classement->setDefaites(0);
            $classement->setNuls(0);
        }

        switch ($resultat) {
            case 'victoire':
                $classement->setVictoires($classement->getVictoires() + 1);
                // Points for victory should come from Sport entity config
                // For now, using a placeholder value
                $classement->setPoints($classement->getPoints() + 3);
                break;
            case 'defaite':
                $classement->setDefaites($classement->getDefaites() + 1);
                // Points for defeat should come from Sport entity config
                // For now, using a placeholder value
                $classement->setPoints($classement->getPoints() + 0);
                break;
            case 'nul':
                $classement->setNuls($classement->getNuls() + 1);
                // Points for draw should come from Sport entity config
                // For now, using a placeholder value
                $classement->setPoints($classement->getPoints() + 1);
                break;
        }

        $this->entityManager->persist($classement);
        $this->entityManager->flush();
    }
}


