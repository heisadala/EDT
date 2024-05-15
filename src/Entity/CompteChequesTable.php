<?php

namespace App\Entity;

use App\Repository\CompteChequesTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteChequesTableRepository::class)]
class CompteChequesTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $banque = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $projet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $recu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $regle = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $debit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $credit = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $facture = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $operation = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $commentaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }
    public function setBanque(?string $banque): static
    {
        $this->banque = $banque;

        return $this;
    }

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProject(?string $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getRecu(): ?\DateTimeInterface
    {
        return $this->recu;
    }

    public function setRecu(?\DateTimeInterface $recu): static
    {
        $this->recu = $recu;

        return $this;
    }

    public function getRegle(): ?\DateTimeInterface
    {
        return $this->regle;
    }

    public function setRegle(?\DateTimeInterface $regle): static
    {
        $this->regle = $regle;

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

    public function setCredit(?string $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): static
    {
        $this->facture = $facture;

        return $this;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function setOperation(?string $operation): static
    {
        $this->operation = $operation;

        return $this;
    }


    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
