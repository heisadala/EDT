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
    private ?int $table = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $inscription = null;

    #[ORM\Column]
    private ?int $exposant_id = null;

    #[ORM\Column]
    private ?int $metres = null;


    #[ORM\Column]
    private ?int $metres_conf = null;

    #[ORM\Column]
    private ?int $grille = null;

    #[ORM\Column]
    private ?int $grille_conf = null;


    #[ORM\Column(length: 3)]
    private ?string $electricite = null;

    
    #[ORM\Column(length: 3)]
    private ?string $elec_conf = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $tarif = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $tarif_conf = null;

    #[ORM\Column]
    private ?int $reglt_salle_id = null;

    #[ORM\Column]
    private ?int $patate = null;

    #[ORM\Column]
    private ?int $brandade = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column]
    private ?int $reglt_repas_id = null;

        
    #[ORM\Column(length: 100)]
    private ?string $commentaire = null;

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

    public function geTable(): ?int
    {
        return $this->table;
    }

    public function setTable(int $table): static
    {
        $this->table = $table;

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

    public function getMetresConf(): ?int
    {
        return $this->metres_conf;
    }

    public function setMetresConf(int $metres_conf): static
    {
        $this->metres_conf = $metres_conf;

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


    public function getGrilleConf(): ?int
    {
        return $this->grille_conf;
    }

    public function setGrilleConf(int $grille_conf): static
    {
        $this->grille_conf = $grille_conf;

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

    
    public function getElecConf(): ?string
    {
        return $this->elec_conf;
    }

    public function setElecConf(string $elec_conf): static
    {
        $this->elec_conf = $elec_conf;

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


    public function getTarifConf(): ?string
    {
        return $this->tarif_conf;
    }

    public function setTarifConf(string $tarif_conf): static
    {
        $this->tarif_conf = $tarif_conf;

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

    public function getPatate(): ?int
    {
        return $this->patate;
    }

    public function setPatate(int $patate): static
    {
        $this->patate = $patate;

        return $this;
    }

    public function getBrandade(): ?int
    {
        return $this->brandade;
    }

    public function setBrandade(int $brandade): static
    {
        $this->brandade = $brandade;

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

    
    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

}
