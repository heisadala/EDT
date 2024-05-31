<?php

namespace App\Entity;

use App\Repository\ProjetsDevisTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetsDevisTableRepository::class)]
class ProjetsDevisTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $projet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $d_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $f_date = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $p_recu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $p_sig = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $d_recu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $d_sig = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $d_montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $a_date_1 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $acompte_1 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $a_date_2 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $acompte_2 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $f_recu = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $f_montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $f_regle = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $f_operation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProjet(?string $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getDDate(): ?\DateTimeInterface
    {
        return $this->d_date;
    }

    public function setDDate(?\DateTimeInterface $d_date): static
    {
        $this->d_date = $d_date;

        return $this;
    }

    public function getFDate(): ?\DateTimeInterface
    {
        return $this->f_date;
    }

    public function setFDate(?\DateTimeInterface $f_date): static
    {
        $this->f_date = $f_date;

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

    public function getPRecu(): ?\DateTimeInterface
    {
        return $this->p_recu;
    }

    public function setPRecu(?\DateTimeInterface $p_recu): static
    {
        $this->p_recu = $p_recu;

        return $this;
    }

    public function getPSig(): ?\DateTimeInterface
    {
        return $this->p_sig;
    }

    public function setPSig(?\DateTimeInterface $p_sig): static
    {
        $this->p_sig = $p_sig;

        return $this;
    }

    public function getDRecu(): ?\DateTimeInterface
    {
        return $this->d_recu;
    }

    public function setDRecu(?\DateTimeInterface $d_recu): static
    {
        $this->d_recu = $d_recu;

        return $this;
    }

    public function getDSig(): ?\DateTimeInterface
    {
        return $this->d_sig;
    }

    public function setDSig(?\DateTimeInterface $d_sig): static
    {
        $this->d_sig = $d_sig;

        return $this;
    }

    public function getDMontant(): ?string
    {
        return $this->d_montant;
    }

    public function setDMontant(?string $d_montant): static
    {
        $this->d_montant = $d_montant;

        return $this;
    }

    public function getADate1(): ?\DateTimeInterface
    {
        return $this->a_date_1;
    }

    public function setADate1(?\DateTimeInterface $a_date_1): static
    {
        $this->a_date_1 = $a_date_1;

        return $this;
    }

    public function getAcompte1(): ?string
    {
        return $this->acompte_1;
    }

    public function setAcompte1(?string $acompte_1): static
    {
        $this->acompte_1 = $acompte_1;

        return $this;
    }

    public function getADate2(): ?\DateTimeInterface
    {
        return $this->a_date_2;
    }

    public function setADate2(?\DateTimeInterface $a_date_2): static
    {
        $this->a_date_2 = $a_date_2;

        return $this;
    }

    public function getAcompte2(): ?string
    {
        return $this->acompte_2;
    }

    public function setAcompte2(?string $acompte_2): static
    {
        $this->acompte_2 = $acompte_2;

        return $this;
    }

    public function getFRecu(): ?\DateTimeInterface
    {
        return $this->f_recu;
    }

    public function setFRecu(?\DateTimeInterface $f_recu): static
    {
        $this->f_recu = $f_recu;

        return $this;
    }

    public function getFMontant(): ?string
    {
        return $this->f_montant;
    }

    public function setFMontant(?string $f_montant): static
    {
        $this->f_montant = $f_montant;

        return $this;
    }

    public function getFRegle(): ?\DateTimeInterface
    {
        return $this->f_regle;
    }

    public function setFRegle(?\DateTimeInterface $f_regle): static
    {
        $this->f_regle = $f_regle;

        return $this;
    }

    public function getFOperation(): ?string
    {
        return $this->f_operation;
    }

    public function setFOperation(?string $f_operation): static
    {
        $this->f_operation = $f_operation;

        return $this;
    }
}
