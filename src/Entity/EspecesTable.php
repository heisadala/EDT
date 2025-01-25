<?php

namespace App\Entity;

use App\Repository\EspecesTableRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: EspecesTableRepository::class)]
class EspecesTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $especes_id = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $manifestation_id = 0;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $caisse_id = 0;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $projet_id = 0;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $donateur_id = 0;


    #[ORM\Column(length: 5, nullable: false)]
    private ?int $edt_id = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_50 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_20 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_10 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_5 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_2 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_1 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_050 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_020 = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_010 = 0;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_50 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_20 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_10 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_5 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_2 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_1 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_050 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_020 = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_010 = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant = null;

    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_50_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_20_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_10_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_5_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_2_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_1_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_050_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_020_apres = 0;
    
    #[ORM\Column(length: 5, nullable: false)]
    private ?int $nombre_010_apres = 0;
    
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_50_apres = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_20_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_10_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_5_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_2_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_1_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_050_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_020_apres = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_010_apres = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $montant_apres = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $cheques = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $tpe = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $dons = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $recette = null;


    public function getEspecesId(): ?int
    {
        return $this->especes_id;
    }
    public function getManifestationId(): ?int
    {
        return $this->manifestation_id;
    }
    public function setManifestationId(?int $manifestation_id): static
    {
        $this->manifestation_id = $manifestation_id;

        return $this;
    }

    public function getCaisseId(): ?int
    {
        return $this->caisse_id;
    }
    public function setCaisseId(?int $caisse_id): static
    {
        $this->caisse_id = $caisse_id;

        return $this;
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

    
    public function getDonateurId(): ?int
    {
        return $this->donateur_id;
    }
    public function setDonateurId(?int $donateur_id): static
    {
        $this->donateur_id = $donateur_id;

        return $this;
    }
   
    public function getEdtId(): ?int
    {
        return $this->edt_id;
    }
    public function setEdtId(?int $edt_id): static
    {
        $this->edt_id = $edt_id;

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

    public function getCheques(): ?string
    {
        return $this->cheques;
    }

    public function setCheques(?string $cheques): static
    {
        $this->cheques = $cheques;

        return $this;
    }

    public function getTpe(): ?string
    {
        return $this->tpe;
    }

    public function setTpe(?string $tpe): static
    {
        $this->tpe = $tpe;

        return $this;
    }


    public function getDons(): ?string
    {
        return $this->dons;
    }

    public function setDons(?string $dons): static
    {
        $this->dons = $dons;

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

    public function getMontantApres(): ?string
    {
        return $this->montant_apres;
    }

    public function setMontantApres(?string $montant_apres): static
    {
        $this->montant_apres = $montant_apres;

        return $this;
    }

    public function getRecette(): ?string
    {
        return $this->recette;
    }

    public function setRecette(?string $recette): static
    {
        $this->recette = $recette;

        return $this;
    }

    public function getNombre_50(): ?string
    {
        return $this->nombre_50;
    }

    public function setNombre_50(?string $nombre_50): static
    {
        $this->nombre_50 = $nombre_50;

        return $this;
    }


    public function getNombre_20(): ?string
    {
        return $this->nombre_20;
    }

    public function setNombre_20(?string $nombre_20): static
    {
        $this->nombre_20 = $nombre_20;

        return $this;
    }


    public function getNombre_10(): ?string
    {
        return $this->nombre_10;
    }

    public function setNombre_10(?string $nombre_10): static
    {
        $this->nombre_10 = $nombre_10;

        return $this;
    }


    public function getNombre_5(): ?string
    {
        return $this->nombre_5;
    }

    public function setNombre_5(?string $nombre_5): static
    {
        $this->nombre_5 = $nombre_5;

        return $this;
    }


    public function getNombre_2(): ?string
    {
        return $this->nombre_2;
    }

    public function setNombre_2(?string $nombre_2): static
    {
        $this->nombre_2 = $nombre_2;

        return $this;
    }


    public function getNombre_1(): ?string
    {
        return $this->nombre_1;
    }

    public function setNombre_1(?string $nombre_1): static
    {
        $this->nombre_1 = $nombre_1;

        return $this;
    }


    public function getNombre_050(): ?string
    {
        return $this->nombre_050;
    }

    public function setNombre_050(?string $nombre_050): static
    {
        $this->nombre_050 = $nombre_050;

        return $this;
    }


    public function getNombre_020(): ?string
    {
        return $this->nombre_020;
    }

    public function setNombre_020(?string $nombre_020): static
    {
        $this->nombre_020 = $nombre_020;

        return $this;
    }


    public function getNombre_010(): ?string
    {
        return $this->nombre_010;
    }

    public function setNombre_010(?string $nombre_010): static
    {
        $this->nombre_010 = $nombre_010;

        return $this;
    }



    public function getMontant_50(): ?string
    {
        return $this->montant_50;
    }

    public function setMontant_50(?string $montant_50): static
    {
        $this->montant_50 = $montant_50;

        return $this;
    }


    public function getMontant_20(): ?string
    {
        return $this->montant_20;
    }

    public function setMontant_20(?string $montant_20): static
    {
        $this->montant_20 = $montant_20;

        return $this;
    }

    public function getMontant_10(): ?string
    {
        return $this->montant_10;
    }

    public function setMontant_10(?string $montant_10): static
    {
        $this->montant_10 = $montant_10;

        return $this;
    }

    public function getMontant_5(): ?string
    {
        return $this->montant_5;
    }

    public function setMontant_5(?string $montant_5): static
    {
        $this->montant_5 = $montant_5;

        return $this;
    }

    public function getMontant_2(): ?string
    {
        return $this->montant_2;
    }

    public function setMontant_2(?string $montant_2): static
    {
        $this->montant_2 = $montant_2;

        return $this;
    }

    public function getMontant_1(): ?string
    {
        return $this->montant_1;
    }

    public function setMontant_1(?string $montant_1): static
    {
        $this->montant_1 = $montant_1;

        return $this;
    }

    public function getMontant_050(): ?string
    {
        return $this->montant_050;
    }

    public function setMontant_050(?string $montant_050): static
    {
        $this->montant_050 = $montant_050;

        return $this;
    }

    public function getMontant_020(): ?string
    {
        return $this->montant_020;
    }

    public function setMontant_020(?string $montant_020): static
    {
        $this->montant_020 = $montant_020;

        return $this;
    }

    public function getMontant_010(): ?string
    {
        return $this->montant_010;
    }

    public function setMontant_010(?string $montant_010): static
    {
        $this->montant_010 = $montant_010;

        return $this;
    }



    
    public function getNombre_50_apres(): ?string
    {
        return $this->nombre_50_apres;
    }

    public function setNombre_50_apres(?string $nombre_50_apres): static
    {
        $this->nombre_50_apres = $nombre_50_apres;

        return $this;
    }


    public function getNombre_20_apres(): ?string
    {
        return $this->nombre_20_apres;
    }

    public function setNombre_20_apres(?string $nombre_20_apres): static
    {
        $this->nombre_20_apres = $nombre_20_apres;

        return $this;
    }


    public function getNombre_10_apres(): ?string
    {
        return $this->nombre_10_apres;
    }

    public function setNombre_10_apres(?string $nombre_10_apres): static
    {
        $this->nombre_10_apres = $nombre_10_apres;

        return $this;
    }


    public function getNombre_5_apres(): ?string
    {
        return $this->nombre_5_apres;
    }

    public function setNombre_5_apres(?string $nombre_5_apres): static
    {
        $this->nombre_5_apres = $nombre_5_apres;

        return $this;
    }


    public function getNombre_2_apres(): ?string
    {
        return $this->nombre_2_apres;
    }

    public function setNombre_2_apres(?string $nombre_2_apres): static
    {
        $this->nombre_2_apres = $nombre_2_apres;

        return $this;
    }


    public function getNombre_1_apres(): ?string
    {
        return $this->nombre_1_apres;
    }

    public function setNombre_1_apres(?string $nombre_1_apres): static
    {
        $this->nombre_1_apres = $nombre_1_apres;

        return $this;
    }


    public function getNombre_050_apres(): ?string
    {
        return $this->nombre_050_apres;
    }

    public function setNombre_050_apres(?string $nombre_050_apres): static
    {
        $this->nombre_050_apres = $nombre_050_apres;

        return $this;
    }


    public function getNombre_020_apres(): ?string
    {
        return $this->nombre_020_apres;
    }

    public function setNombre_020_apres(?string $nombre_020_apres): static
    {
        $this->nombre_020_apres = $nombre_020_apres;

        return $this;
    }


    public function getNombre_010_apres(): ?string
    {
        return $this->nombre_010_apres;
    }

    public function setNombre_010_apres(?string $nombre_010_apres): static
    {
        $this->nombre_010_apres = $nombre_010_apres;

        return $this;
    }



    public function getMontant_50_apres(): ?string
    {
        return $this->montant_50_apres;
    }

    public function setMontant_50_apres(?string $montant_50_apres): static
    {
        $this->montant_50_apres = $montant_50_apres;

        return $this;
    }


    public function getMontant_20_apres(): ?string
    {
        return $this->montant_20_apres;
    }

    public function setMontant_20_apres(?string $montant_20_apres): static
    {
        $this->montant_20_apres = $montant_20_apres;

        return $this;
    }

    public function getMontant_10_apres(): ?string
    {
        return $this->montant_10_apres;
    }

    public function setMontant_10_apres(?string $montant_10_apres): static
    {
        $this->montant_10_apres = $montant_10_apres;

        return $this;
    }

    public function getMontant_5_apres(): ?string
    {
        return $this->montant_5_apres;
    }

    public function setMontant_5_apres(?string $montant_5_apres): static
    {
        $this->montant_5_apres = $montant_5_apres;

        return $this;
    }

    public function getMontant_2_apres(): ?string
    {
        return $this->montant_2_apres;
    }

    public function setMontant_2_apres(?string $montant_2_apres): static
    {
        $this->montant_2_apres = $montant_2_apres;

        return $this;
    }

    public function getMontant_1_apres(): ?string
    {
        return $this->montant_1_apres;
    }

    public function setMontant_1_apres(?string $montant_1_apres): static
    {
        $this->montant_1_apres = $montant_1_apres;

        return $this;
    }

    public function getMontant_050_apres(): ?string
    {
        return $this->montant_050_apres;
    }

    public function setMontant_050_apres(?string $montant_050_apres): static
    {
        $this->montant_050_apres = $montant_050_apres;

        return $this;
    }

    public function getMontant_020_apres(): ?string
    {
        return $this->montant_020_apres;
    }

    public function setMontant_020_apres(?string $montant_020_apres): static
    {
        $this->montant_020_apres = $montant_020_apres;

        return $this;
    }

    public function getMontant_010_apres(): ?string
    {
        return $this->montant_010_apres;
    }

    public function setMontant_010_apres(?string $montant_010_apres): static
    {
        $this->montant_010_apres = $montant_010_apres;

        return $this;
    }

}
