<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Competition>
     */
    #[ORM\OneToMany(targetEntity: Competition::class, mappedBy: 'sport')]
    private Collection $competitions;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Competition>
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): static
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions->add($competition);
            $competition->setSport($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): static
    {
        if ($this->competitions->removeElement($competition)) {
            // set the owning side to null (unless already changed)
            if ($competition->getSport() === $this) {
                $competition->setSport(null);
            }
        }

        return $this;
    }
    
    #[ORM\Column(name: 'pointsVictoire', nullable: true)]
private ?int $pointsVictoire = null;

        #[ORM\Column(name: 'pointsNul', nullable: true)]

    private ?int $pointsNul = null;
   #[ORM\Column(name: 'pointsDefaite', nullable: true)]

    private ?int $pointsDefaite = null;

    public function getPointsVictoire(): ?int
    {
        return $this->pointsVictoire;
    }
    
    public function setPointsVictoire(?int $pointsVictoire): static
    {
        $this->pointsVictoire = $pointsVictoire;
        
        return $this;
    }

    public function getPointsNul(): ?int
    {
        return $this->pointsNul;
    }
    
    public function setPointsNul(?int $pointsNul): static
    {
        $this->pointsNul = $pointsNul;
        
        return $this;
    }

    public function getPointsDefaite(): ?int
    {
        return $this->pointsDefaite;
    }
    
    public function setPointsDefaite(?int $pointsDefaite): static
    {
        $this->pointsDefaite = $pointsDefaite;
        
        return $this;
    }
}
