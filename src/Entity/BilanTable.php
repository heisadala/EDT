<?php

namespace App\Entity;

use App\Repository\BilanTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BilanTableRepository::class)]
class BilanTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $bilan_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $don = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $don_particuliers = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $don_entreprises = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $don_ecoles = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $don_associations = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $adhesions = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_manifestations = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_theatre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_handifference = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_rando_nature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_trail_estran = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_marche_noel = null;
    

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_manifestations = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_theatre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_handifference = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_rando_nature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_trail_estran = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_marche_noel = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $projets = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $hdj = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $camsp = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $trestel = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $estran = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $hds = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $je = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $sesad = null;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $ue = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $fonctionnement = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $fournitures = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $assurance = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $divers = null;


    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $r_banque = null;


    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $d_banque = null;


    public function getBilanId(): ?int
    {
        return $this->bilan_id;
    }

    public function getDon(): ?string
    {
        return $this->don;
    }

    public function setDon(string $don): static
    {
        $this->don = $don;

        return $this;
    }

    public function getDonParticuliers(): ?string
    {
        return $this->don_particuliers;
    }

    public function setDonParticuliers(string $don_particuliers): static
    {
        $this->don_particuliers = $don_particuliers;

        return $this;
    }

    public function getDonEntreprises(): ?string
    {
        return $this->don_entreprises;
    }

    public function setDonEntreprises(string $don_entreprises): static
    {
        $this->don_entreprises = $don_entreprises;

        return $this;
    }

    public function getDonEcoles(): ?string
    {
        return $this->don_ecoles;
    }

    public function setDonEcoles(string $don_ecoles): static
    {
        $this->don_ecoles = $don_ecoles;

        return $this;
    }

    public function getDonAssociations(): ?string
    {
        return $this->don_associations;
    }

    public function setDonAssociations(string $don_associations): static
    {
        $this->don_associations = $don_associations;

        return $this;
    }

    public function getAdhesions(): ?string
    {
        return $this->adhesions;
    }

    public function setAdhesions(string $adhesions): static
    {
        $this->adhesions = $adhesions;

        return $this;
    }

    public function getRManifestations(): ?string
    {
        return $this->r_manifestations;
    }

    public function setRManifestations(string $r_manifestations): static
    {
        $this->r_manifestations = $r_manifestations;

        return $this;
    }

    public function getRTheatre(): ?string
    {
        return $this->r_theatre;
    }

    public function setRTheatre(string $r_theatre): static
    {
        $this->r_theatre = $r_theatre;

        return $this;
    }

    public function getRHandifference(): ?string
    {
        return $this->r_handifference;
    }

    public function setRHandifference(string $r_handifference): static
    {
        $this->r_handifference = $r_handifference;

        return $this;
    }

    public function getRRandoNature(): ?string
    {
        return $this->r_rando_nature;
    }

    public function setRRandoNature(string $r_rando_nature): static
    {
        $this->r_rando_nature = $r_rando_nature;

        return $this;
    }

    public function getRTrailEstran(): ?string
    {
        return $this->r_trail_estran;
    }

    public function setRTrailEstran(string $r_trail_estran): static
    {
        $this->r_trail_estran = $r_trail_estran;

        return $this;
    }

    public function getRMarcheNoel(): ?string
    {
        return $this->r_marche_noel;
    }

    public function setRMarcheNoel(string $r_marche_noel): static
    {
        $this->r_marche_noel = $r_marche_noel;

        return $this;
    }


    public function getDManifestations(): ?string
    {
        return $this->d_manifestations;
    }


    public function setDManifestations(string $d_manifestations): static
    {
        $this->d_manifestations = $d_manifestations;

        return $this;
    }

    public function getDTheatre(): ?string
    {
        return $this->d_theatre;
    }

    public function setDTheatre(string $d_theatre): static
    {
        $this->d_theatre = $d_theatre;

        return $this;
    }
    public function getDHandifference(): ?string
    {
        return $this->d_handifference;
    }

    public function setDHandifference(string $d_handifference): static
    {
        $this->d_handifference = $d_handifference;

        return $this;
    }

    public function getDRandoNature(): ?string
    {
        return $this->d_rando_nature;
    }

    public function setDRandoNature(string $d_rando_nature): static
    {
        $this->d_rando_nature = $d_rando_nature;

        return $this;
    }

    public function getDTrailEstran(): ?string
    {
        return $this->d_trail_estran;
    }

    public function setDTrailEstran(string $d_trail_estran): static
    {
        $this->d_trail_estran = $d_trail_estran;

        return $this;
    }

    public function getDMarcheNoel(): ?string
    {
        return $this->d_marche_noel;
    }

    public function setDMarcheNoel(string $d_marche_noel): static
    {
        $this->d_marche_noel = $d_marche_noel;

        return $this;
    }


    public function getProjets(): ?string
    {
        return $this->projets;
    }

    public function setProjets(string $projets): static
    {
        $this->projets = $projets;

        return $this;
    }


    public function getHdj(): ?string
    {
        return $this->hdj;
    }

    public function setHdj(string $hdj): static
    {
        $this->hdj = $hdj;

        return $this;
    }

    
    public function getHds(): ?string
    {
        return $this->hds;
    }

    public function setHds(string $hds): static
    {
        $this->hds = $hds;

        return $this;
    }

   
    public function getJe(): ?string
    {
        return $this->je;
    }

    public function setJe(string $je): static
    {
        $this->je = $je;

        return $this;
    }

    public function getUe(): ?string
    {
        return $this->ue;
    }

    public function setUe(string $ue): static
    {
        $this->ue = $ue;

        return $this;
    }


    public function getCamsp(): ?string
    {
        return $this->camsp;
    }

    public function setCamsp(string $camsp): static
    {
        $this->camsp = $camsp;

        return $this;
    }


    public function getTrestel(): ?string
    {
        return $this->trestel;
    }

    public function setTrestel(string $trestel): static
    {
        $this->trestel = $trestel;

        return $this;
    }

    public function getEstran(): ?string
    {
        return $this->estran;
    }

    public function setEstran(string $estran): static
    {
        $this->estran = $estran;

        return $this;
    }

    public function getSesad(): ?string
    {
        return $this->sesad;
    }

    public function setSesad(string $sesad): static
    {
        $this->sesad = $sesad;

        return $this;
    }

    public function getFonctionnement(): ?string
    {
        return $this->fonctionnement;
    }

    public function setFonctionnement(string $fonctionnement): static
    {
        $this->fonctionnement = $fonctionnement;

        return $this;
    }

    public function getFournitures(): ?string
    {
        return $this->fournitures;
    }

    public function setFournitures(string $fournitures): static
    {
        $this->fournitures = $fournitures;

        return $this;
    }

    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    public function setAssurance(string $assurance): static
    {
        $this->assurance = $assurance;

        return $this;
    }

    public function getDivers(): ?string
    {
        return $this->divers;
    }

    public function setDivers(string $divers): static
    {
        $this->sesad = $divers;

        return $this;
    }
    public function getRBanque(): ?string
    {
        return $this->r_banque;
    }

    public function setRBanque(string $r_banque): static
    {
        $this->r_banque = $r_banque;

        return $this;
    }
    public function getDBanque(): ?string
    {
        return $this->d_banque;
    }

    public function setDBanque(string $d_banque): static
    {
        $this->d_banque = $d_banque;

        return $this;
    }

}
