<?php

namespace App\Entity;

use App\Repository\ProjectTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectTableRepository::class)]
class ProjectTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $projet_id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $projet = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $prestataire_id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $affectation = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $affectation_id = null;
 
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $donateur_id = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $d_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $f_date = null;

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

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $f_montant = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $c_montant = null;


    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $montant = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $etat_id = 0;

    public function getProjetId(): ?int
    {
        return $this->projet_id;
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

    public function getPrestataireId(): ?int
    {
        return $this->prestataire_id;
    }

    public function setPrestataireId(int $prestataire_id): static
    {
        $this->prestataire_id = $prestataire_id;

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

    public function getFMontant(): ?string
    {
        return $this->f_montant;
    }

    public function setFMontant(?string $f_montant): static
    {
        $this->f_montant = $f_montant;

        return $this;
    }
    public function getCMontant(): ?string
    {
        return $this->c_montant;
    }

    public function setCMontant(?string $c_montant): static
    {
        $this->c_montant = $c_montant;

        return $this;
    }
    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): static
    {
        $this->montant = $montant;

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


}
