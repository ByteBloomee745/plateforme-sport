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

        // Récupérer le sport associé à la compétition
        $sport = $competition->getSport();
        
        // Utiliser les points configurés dans le sport
        switch ($resultat) {
            case 'victoire':
                $classement->setVictoires($classement->getVictoires() + 1);
                $pointsToAdd = $sport->getPointsVictoire() ?? 3; // Valeur par défaut si null
                $classement->setPoints($classement->getPoints() + $pointsToAdd);
                break;
            case 'defaite':
                $classement->setDefaites($classement->getDefaites() + 1);
                $pointsToAdd = $sport->getPointsDefaite() ?? 0; // Valeur par défaut si null
                $classement->setPoints($classement->getPoints() + $pointsToAdd);
                break;
            case 'nul':
                $classement->setNuls($classement->getNuls() + 1);
                $pointsToAdd = $sport->getPointsNul() ?? 1; // Valeur par défaut si null
                $classement->setPoints($classement->getPoints() + $pointsToAdd);
                break;
        }

        $this->entityManager->persist($classement);
        $this->entityManager->flush();
    }

    public function mettreAJourClassementEquipe(\App\Entity\Equipe $equipe, Competition $competition, string $resultat): void
    {
        // Récupérer tous les membres de l'équipe
        // Cette partie dépend de votre modèle de données
        // Si vous avez une relation entre Membre et Equipe, vous pouvez la récupérer ici
        
        // Pour l'instant, nous allons simuler une mise à jour pour l'équipe entière
        // Dans un cas réel, vous devriez mettre à jour chaque membre de l'équipe
        
        // Exemple fictif - à adapter selon votre modèle de données
        $membres = $this->entityManager->getRepository(Membre::class)->findByEquipe($equipe);
        
        foreach ($membres as $membre) {
            $this->mettreAJourClassement($membre, $competition, $resultat);
        }
    }
}


