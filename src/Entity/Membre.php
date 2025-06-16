<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nomPrenom', length: 255)]
    private ?string $nomPrenom = null;

    #[ORM\Column(name: 'dateNaissance', type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateNaissance = null;
    /**
     * @var Collection<int, Classement>
     */
    #[ORM\OneToMany(targetEntity: Classement::class, mappedBy: 'membre')]
    private Collection $classements;

    /**
     * @var Collection<int, Entrainement>
     */
    #[ORM\OneToMany(targetEntity: Entrainement::class, mappedBy: 'coach')]
    private Collection $entrainements;

    /**
     * @var Collection<int, Membership>
     */
    #[ORM\OneToMany(targetEntity: Membership::class, mappedBy: 'membre', orphanRemoval: true)]
    private Collection $memberships;

    public function __construct()
    {
        $this->classements = new ArrayCollection();
        $this->entrainements = new ArrayCollection();
        $this->memberships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom): static
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Classement>
     */
    public function getClassements(): Collection
    {
        return $this->classements;
    }

    public function addClassement(Classement $classement): static
    {
        if (!$this->classements->contains($classement)) {
            $this->classements->add($classement);
            $classement->setMembre($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): static
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getMembre() === $this) {
                $classement->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Entrainement>
     */
    public function getEntrainements(): Collection
    {
        return $this->entrainements;
    }

    public function addEntrainement(Entrainement $entrainement): static
    {
        if (!$this->entrainements->contains($entrainement)) {
            $this->entrainements->add($entrainement);
            $entrainement->setCoach($this);
        }

        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement): static
    {
        if ($this->entrainements->removeElement($entrainement)) {
            // set the owning side to null (unless already changed)
            if ($entrainement->getCoach() === $this) {
                $entrainement->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Membership>
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    public function addMembership(Membership $membership): static
    {
        if (!$this->memberships->contains($membership)) {
            $this->memberships->add($membership);
            $membership->setMembre($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): static
    {
        if ($this->memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getMembre() === $this) {
                $membership->setMembre(null);
            }
        }

        return $this;
    }
}
