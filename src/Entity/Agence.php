<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $cp = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descirption = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'agence', targetEntity: Vehicule::class)]
    private Collection $id_agence;

    public function __construct()
    {
        $this->id_agence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getDescirption(): ?string
    {
        return $this->descirption;
    }

    public function setDescirption(string $descirption): self
    {
        $this->descirption = $descirption;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getIdAgence(): Collection
    {
        return $this->id_agence;
    }

    public function addIdAgence(Vehicule $idAgence): self
    {
        if (!$this->id_agence->contains($idAgence)) {
            $this->id_agence->add($idAgence);
            $idAgence->setAgence($this);
        }

        return $this;
    }

    public function removeIdAgence(Vehicule $idAgence): self
    {
        if ($this->id_agence->removeElement($idAgence)) {
            // set the owning side to null (unless already changed)
            if ($idAgence->getAgence() === $this) {
                $idAgence->setAgence(null);
            }
        }

        return $this;
    }

}
