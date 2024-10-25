<?php

namespace App\Entity;

use App\Repository\YearTableRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YearTableRepository::class)]
class YearTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $year_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $cc_begin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $cc_now = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $titre_begin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $titre_now = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $livret_begin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $livret_now = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $caisse_begin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $caisse_now = null;

    public function getYearId(): ?int
    {
        return $this->year_id;
    }

    public function getCc_begin(): ?string
    {
        return $this->cc_begin;
    }

    public function setCcBegin(?string $cc_begin): static
    {
        $this->cc_begin = $cc_begin;

        return $this;
    }

    public function getCc_now(): ?string
    {
        return $this->cc_now;
    }

    public function setCcNow(?string $cc_now): static
    {
        $this->cc_now = $cc_now;

        return $this;
    }

    public function getTitre_begin(): ?string
    {
        return $this->titre_begin;
    }

    public function setTitreBegin(?string $titre_begin): static
    {
        $this->titre_begin = $titre_begin;

        return $this;
    }

    public function getTitre_now(): ?string
    {
        return $this->titre_now;
    }

    public function setTitreNow(?string $titre_now): static
    {
        $this->titre_now = $titre_now;

        return $this;
    }

    public function getLivret_begin(): ?string
    {
        return $this->livret_begin;
    }

    public function setLivretBegin(?string $livret_begin): static
    {
        $this->livret_begin = $livret_begin;

        return $this;
    }

    public function getLivret_now(): ?string
    {
        return $this->livret_now;
    }

    public function setLivretNow(?string $livret_now): static
    {
        $this->livret_now = $livret_now;

        return $this;
    }

    public function getCaisse_begin(): ?string
    {
        return $this->caisse_begin;
    }

    public function setCaisseBegin(?string $caisse_begin): static
    {
        $this->caisse_begin = $caisse_begin;

        return $this;
    }

    public function getCaisse_now(): ?string
    {
        return $this->caisse_now;
    }

    public function setCaisseNow(?string $caisse_now): static
    {
        $this->caisse_now = $caisse_now;

        return $this;
    }
}
