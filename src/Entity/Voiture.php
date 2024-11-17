<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $immatriculation = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMiseEnCirculation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRentreGarage = null;

    #[ORM\Column]
    private ?int $nbPlaces = null;

    #[ORM\Column(length: 11)]
    private ?string $typeBoiteVitesse = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Image::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToOne(targetEntity: Modele::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Modele $modele = null;

    #[ORM\ManyToOne(targetEntity: Marque::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    private array $imageFiles = []; // Non mappé (utilisé uniquement pour gérer les fichiers dans le formulaire)

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->dateMiseEnCirculation;
    }

    public function setDateMiseEnCirculation(\DateTimeInterface $dateMiseEnCirculation): static
    {
        $this->dateMiseEnCirculation = $dateMiseEnCirculation;

        return $this;
    }

    public function getDateRentreGarage(): ?\DateTimeInterface
    {
        return $this->dateRentreGarage;
    }

    public function setDateRentreGarage(\DateTimeInterface $dateRentreGarage): static
    {
        $this->dateRentreGarage = $dateRentreGarage;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): static
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getTypeBoiteVitesse(): ?string
    {
        return $this->typeBoiteVitesse;
    }

    public function setTypeBoiteVitesse(string $typeBoiteVitesse): static
    {
        $this->typeBoiteVitesse = $typeBoiteVitesse;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setVoiture($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getVoiture() === $this) {
                $image->setVoiture(null);
            }
        }

        return $this;
    }

    public function getImageFiles(): array
    {
        return $this->imageFiles;
    }

    public function setImageFiles(array $imageFiles): static
    {
        $this->imageFiles = $imageFiles;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }
}
