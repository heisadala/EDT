<?php

namespace App\Entity;

use App\Repository\EtatTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatTableRepository::class)]
class EtatTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $etat_id = null;

    #[ORM\Column(length: 50)]
    private ?string $etat = null;

    #[ORM\Column(length: 50)]
    private ?string $bg_color = null;

    #[ORM\Column(length: 50)]
    private ?string $text_color = null;

    public function getEtatId(): ?int
    {
        return $this->etat_id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bg_color;
    }

    public function setBgColor(string $bg_color): static
    {
        $this->bg_color = $bg_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(string $text_color): static
    {
        $this->text_color = $text_color;

        return $this;
    }
}
