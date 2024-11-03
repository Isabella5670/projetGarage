<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomMarque = null;

    /**
     * @var Collection<int, Modele>
     */
    #[ORM\OneToMany(targetEntity: Modele::class, mappedBy: 'marque', orphanRemoval: true)]
    private Collection $modeles;

    /**
     * @var Collection<int, Modele>
     */
    #[ORM\OneToMany(targetEntity: Modele::class, mappedBy: 'marque')]
    private Collection $listeModeles;

    public function __construct()
    {
        $this->modeles = new ArrayCollection();
        $this->listeModeles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMarque(): ?string
    {
        return $this->nomMarque;
    }

    public function setNomMarque(string $nomMarque): static
    {
        $this->nomMarque = $nomMarque;

        return $this;
    }

    /**
     * @return Collection<int, Modele>
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    public function addModele(Modele $modele): static
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles->add($modele);
            $modele->setMarque($this);
        }

        return $this;
    }

    public function removeModele(Modele $modele): static
    {
        if ($this->modeles->removeElement($modele)) {
            // set the owning side to null (unless already changed)
            if ($modele->getMarque() === $this) {
                $modele->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Modele>
     */
    public function getListeModeles(): Collection
    {
        return $this->listeModeles;
    }

    public function addListeModele(Modele $listeModele): static
    {
        if (!$this->listeModeles->contains($listeModele)) {
            $this->listeModeles->add($listeModele);
            $listeModele->setMarque($this);
        }

        return $this;
    }

    public function removeListeModele(Modele $listeModele): static
    {
        if ($this->listeModeles->removeElement($listeModele)) {
            // set the owning side to null (unless already changed)
            if ($listeModele->getMarque() === $this) {
                $listeModele->setMarque(null);
            }
        }

        return $this;
    }
}
