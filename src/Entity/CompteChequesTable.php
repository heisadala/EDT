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
    private ?int $compte_id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $banque = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $projet_id = 0;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $etat_id = 0;
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $affectation = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $affectation_id = 0;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $donateur_id = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $debit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $credit = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $facture = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $operation = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $operation_id = 0;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $categorie = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $commentaire = null;



    public function getCompteId(): ?int
    {
        return $this->compte_id;
    }
    public function getProjetId(): ?int
    {
        return $this->projet_id;
    }
    public function setProjetId(?int $projet_id): static
    {
        $this->projet_id = $projet_id;

        return $this;
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

    public function getAffectation(): ?string
    {
        return $this->affectation;
    }

    public function setAffectation(?string $affectation): static
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->recu = $date;

        return $this;
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
    public function getEtatId(): ?int
    {
        return $this->etat_id;
    }

    public function setEtatId(int $etat_id): static
    {
        $this->etat_id = $etat_id;

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
    public function getDonateurId(): ?int
    {
        return $this->donateur_id;
    }

    public function setDonateurId(int $donateur_id): static
    {
        $this->donateur_id = $donateur_id;

        return $this;
    }
    public function getOperationId(): ?int
    {
        return $this->operation_id;
    }

    public function setOperationId(int $operation_id): static
    {
        $this->operation_id = $operation_id;

        return $this;
    }
}
