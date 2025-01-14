<?php

namespace App\Entity;

use App\Repository\EdtTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EdtTableRepository::class)]
class EdtTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $edt_id = null;

    #[ORM\Column(length: 50)]
    private ?string $edt_proj = null;

    #[ORM\Column]
    private ?int $affectation_id = null;

    #[ORM\Column(length: 30)]
    private ?string $affectation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $debit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $credit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $c_montant = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant = null;

    public function getEdtId(): ?int
    {
        return $this->edt_id;
    }

    public function getEdtProj(): ?string
    {
        return $this->edt_proj;
    }

    public function setEdtProj(string $edt_proj): static
    {
        $this->edt_proj = $edt_proj;

        return $this;
    }

    public function getAffectationId(): ?int
    {
        return $this->affectation_id;
    }

    public function setAffectationId(int $affectation_id): static
    {
        $this->affectation_id = $affectation_id;

        return $this;
    }

    public function getAffectation(): ?string
    {
        return $this->affectation;
    }

    public function setAffectation(string $affectation): static
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getDebit(): ?string
    {
        return $this->debit;
    }

    public function setDebit(string $debit): static
    {
        $this->debit = $debit;

        return $this;
    }

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    public function setCredit(string $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getCMontant(): ?string
    {
        return $this->c_montant;
    }

    public function setCMontant(string $c_montant): static
    {
        $this->c_montant = $c_montant;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }
}
