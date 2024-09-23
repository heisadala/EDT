<?php

namespace App\Entity;

use App\Repository\AdherantsTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdherantsTableRepository::class)]
class AdherantsTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $adherant_id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $rue = null;

    #[ORM\Column]
    private ?int $ville_id = null;

    #[ORM\Column(length: 80)]
    private ?string $mail = null;

    #[ORM\Column(length: 20)]
    private ?string $tel = null;

    #[ORM\Column]
    private ?int $regle = null;

    #[ORM\Column]
    private ?int $carte = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant = null;

    public function getAdherantId(): ?int
    {
        return $this->adherant_id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVilleId(): ?int
    {
        return $this->ville_id;
    }

    public function setVilleId(int $ville_id): static
    {
        $this->ville_id = $ville_id;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getRegle(): ?int
    {
        return $this->regle;
    }

    public function setRegle(int $regle): static
    {
        $this->regle = $regle;

        return $this;
    }

    public function getCarte(): ?int
    {
        return $this->carte;
    }

    public function setCarte(int $carte): static
    {
        $this->carte = $carte;

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
