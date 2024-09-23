<?php

namespace App\Entity;

use App\Repository\OperationTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationTableRepository::class)]
class OperationTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $operation_id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    public function getOperationId(): ?int
    {
        return $this->operation_id;
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
