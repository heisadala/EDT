<?php

namespace App\Entity;

use App\Repository\StructureTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructureTableRepository::class)]
class StructureTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $structure_id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    public function getStructureId(): ?int
    {
        return $this->structure_id;
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
