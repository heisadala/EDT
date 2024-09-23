<?php

namespace App\Entity;

use App\Repository\AffectationTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationTableRepository::class)]
class AffectationTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $affectation_id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    public function getAffectationId(): ?int
    {
        return $this->affectation_id;
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
}
