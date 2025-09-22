<?php

namespace App\Entity;

use App\Repository\MarcheNoelTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarcheNoelTableRepository::class)]
class MarcheNoelTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $mn_id = null;

    #[ORM\Column]
    private ?int $salle_id = null;

    #[ORM\Column]
    private ?int $numTable = null;

    #[ORM\Column]
    private ?int $exposant_id = null;

    #[ORM\Column]
    private ?int $metres = null;

    #[ORM\Column]
    private ?int $grille = null;

    #[ORM\Column(length: 3)]
    private ?string $electricite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $tarif = null;

    #[ORM\Column]
    private ?int $reglt_salle_id = null;

    #[ORM\Column]
    private ?int $repas_1 = null;

    #[ORM\Column]
    private ?int $repas_2 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column]
    private ?int $reglt_repas_id = null;

    public function getId(): ?int
    {
        return $this->mn_id;
    }

    public function getSalleId(): ?int
    {
        return $this->salle_id;
    }

    public function setSalleId(int $salle_id): static
    {
        $this->salle_id = $salle_id;

        return $this;
    }

    public function getNumTable(): ?string
    {
        return $this->numTable;
    }

    public function setNumTable(string $numTable): static
    {
        $this->numTable = $numTable;

        return $this;
    }

    public function getExposantId(): ?int
    {
        return $this->exposant_id;
    }

    public function setExposantId(int $exposant_id): static
    {
        $this->exposant_id = $exposant_id;

        return $this;
    }

    public function getMetres(): ?int
    {
        return $this->metres;
    }

    public function setMetres(int $metres): static
    {
        $this->metres = $metres;

        return $this;
    }

    public function getGrille(): ?int
    {
        return $this->grille;
    }

    public function setGrille(int $grille): static
    {
        $this->grille = $grille;

        return $this;
    }

    public function getElectricite(): ?string
    {
        return $this->electricite;
    }

    public function setElectricite(string $electricite): static
    {
        $this->electricite = $electricite;

        return $this;
    }

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(string $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getRegltSalleId(): ?int
    {
        return $this->reglt_salle_id;
    }

    public function setRegltSalleId(int $reglt_salle_id): static
    {
        $this->reglt_salle_id = $reglt_salle_id;

        return $this;
    }

    public function getRepas1(): ?int
    {
        return $this->repas_1;
    }

    public function setRepas1(int $repas_1): static
    {
        $this->repas_1 = $repas_1;

        return $this;
    }

    public function getRepas2(): ?int
    {
        return $this->repas_2;
    }

    public function setRepas2(int $repas_2): static
    {
        $this->repas_2 = $repas_2;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRegltRepasId(): ?int
    {
        return $this->reglt_repas_id;
    }

    public function setRegltRepasId(int $reglt_repas_id): static
    {
        $this->reglt_repas_id = $reglt_repas_id;

        return $this;
    }
}
