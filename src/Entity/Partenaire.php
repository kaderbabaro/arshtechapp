<?php

namespace App\Entity;

use App\Repository\PartenaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartenaireRepository::class)]
class Partenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 25)]
    private ?string $numerotel = null;

    #[ORM\Column(length: 150)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description_contrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
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

    public function getNumerotel(): ?string
    {
        return $this->numerotel;
    }

    public function setNumerotel(string $numerotel): static
    {
        $this->numerotel = $numerotel;

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

    public function getDescriptionContrat(): ?string
    {
        return $this->description_contrat;
    }

    public function setDescriptionContrat(string $description_contrat): static
    {
        $this->description_contrat = $description_contrat;

        return $this;
    }
}
