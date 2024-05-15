<?php

namespace App\Entity;

use App\Repository\CompteFondsDeCaissesTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteFondsDeCaissesTableRepository::class)]
class CompteFondsDeCaissesTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $caisse = null;

    #[ORM\Column]
    private ?int $one_cent = null;

    #[ORM\Column]
    private ?int $two_cents = null;

    #[ORM\Column]
    private ?int $five_cents = null;

    #[ORM\Column]
    private ?int $ten_cents = null;

    #[ORM\Column]
    private ?int $twenty_cents = null;

    #[ORM\Column]
    private ?int $fifty_cents = null;

    #[ORM\Column]
    private ?int $one_euro = null;

    #[ORM\Column]
    private ?int $two_euros = null;

    #[ORM\Column]
    private ?int $five_euros = null;

    #[ORM\Column]
    private ?int $ten_euros = null;

    #[ORM\Column]
    private ?int $twenty_euros = null;

    #[ORM\Column]
    private ?int $fifty_euros = null;

    #[ORM\Column]
    private ?int $hundred_euros = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaisse(): ?int
    {
        return $this->caisse;
    }

    public function setCaisse(?int $caisse): static
    {
        $this->caisse = $caisse;

        return $this;
    }

    public function getOneCent(): ?int
    {
        return $this->one_cent;
    }

    public function setOneCent(int $one_cent): static
    {
        $this->one_cent = $one_cent;

        return $this;
    }

    public function getTwoCents(): ?int
    {
        return $this->two_cents;
    }

    public function setTwoCents(int $two_cents): static
    {
        $this->two_cents = $two_cents;

        return $this;
    }

    public function getFiveCents(): ?int
    {
        return $this->five_cents;
    }

    public function setFiveCents(int $five_cents): static
    {
        $this->five_cents = $five_cents;

        return $this;
    }

    public function getTenCents(): ?int
    {
        return $this->ten_cents;
    }

    public function setTenCents(int $ten_cents): static
    {
        $this->ten_cents = $ten_cents;

        return $this;
    }

    public function getTwentyCents(): ?int
    {
        return $this->twenty_cents;
    }

    public function setTwentyCents(int $twenty_cents): static
    {
        $this->twenty_cents = $twenty_cents;

        return $this;
    }

    public function getFiftyCents(): ?int
    {
        return $this->fifty_cents;
    }

    public function setFiftyCents(int $fifty_cents): static
    {
        $this->fifty_cents = $fifty_cents;

        return $this;
    }

    public function getOneEuro(): ?int
    {
        return $this->one_euro;
    }

    public function setOneEuro(int $one_euro): static
    {
        $this->one_euro = $one_euro;

        return $this;
    }

    public function getTwoEuros(): ?int
    {
        return $this->two_euros;
    }

    public function setTwoEuros(int $two_euros): static
    {
        $this->two_euros = $two_euros;

        return $this;
    }

    public function getFiveEuros(): ?int
    {
        return $this->five_euros;
    }

    public function setFiveEuros(int $five_euros): static
    {
        $this->five_euros = $five_euros;

        return $this;
    }

    public function getTenEuros(): ?int
    {
        return $this->ten_euros;
    }

    public function setTenEuros(int $ten_euros): static
    {
        $this->ten_euros = $ten_euros;

        return $this;
    }

    public function getTwentyEuros(): ?int
    {
        return $this->twenty_euros;
    }

    public function setTwentyEuros(int $twenty_euros): static
    {
        $this->twenty_euros = $twenty_euros;

        return $this;
    }

    public function getFiftyEuros(): ?int
    {
        return $this->fifty_euros;
    }

    public function setFiftyEuros(int $fifty_euros): static
    {
        $this->fifty_euros = $fifty_euros;

        return $this;
    }

    public function getHundredEuros(): ?int
    {
        return $this->hundred_euros;
    }

    public function setHundredEuros(int $hundred_euros): static
    {
        $this->hundred_euros = $hundred_euros;

        return $this;
    }
}
