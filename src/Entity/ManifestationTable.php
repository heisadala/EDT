<?php

namespace App\Entity;

use App\Repository\ManifestationTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManifestationTableRepository::class)]
class ManifestationTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $manifestation_id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    public function getManifestationId(): ?int
    {
        return $this->manifestation_id;
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
