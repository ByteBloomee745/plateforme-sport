// ... existing code ...
    #[Route('/recalcul/{competitionId}', name: 'app_classement_recalcul', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function recalculerClassements(int $competitionId): JsonResponse
    {
        $competition = $this->competitionRepository->find($competitionId);
        if (!$competition) {
            return $this->json(['error' => 'Compétition non trouvée'], 404);
        }

        // Réinitialiser tous les classements pour cette compétition
        $classements = $this->classementRepository->findByCompetitionOrderedByPoints($competition);
        foreach ($classements as $classement) {
            $classement->setPoints(0);
            $classement->setVictoires(0);
            $classement->setDefaites(0);
            $classement->setNuls(0);
        }
        $this->entityManager->flush();
        
        // Récupérer tous les matchs de la compétition
        $matchs = $this->entityManager->getRepository(Match::class)
            ->findBy(['competition' => $competition]);
            
        // Recalculer les classements en fonction des résultats des matchs
        foreach ($matchs as $match) {
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
            
            // Mettre à jour les classements
            $this->classementService->mettreAJourClassementEquipe(
                $match->getEquipeA(),
                $competition,
                $resultA
            );
            
            $this->classementService->mettreAJourClassementEquipe(
                $match->getEquipeB(),
                $competition,
                $resultB
            );
        }
        
        return $this->json(['message' => 'Classements recalculés avec succès']);
    }