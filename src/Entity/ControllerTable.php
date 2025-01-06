<?php

namespace App\Entity;

use App\Repository\ContollerTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ControllerTableRepository::class)]
class ControllerTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $tbl = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $background = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bg_color = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $navbar_title = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $header_title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTbl(): ?string
    {
        return $this->tbl;
    }

    public function setTbl(string $tbl): static
    {
        $this->tbl = $tbl;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): static
    {
        $this->background = $background;

        return $this;
    }



    public function getBgColor(): ?string
    {
        return $this->bg_color;
    }

    public function setBgColor(?string $bg_color): static
    {
        $this->bg_color = $bg_color;

        return $this;
    }


    public function getNavbarTitle(): ?string
    {
        return $this->navbar_title;
    }

    public function setNavbarTitle(?string $navbar_title): static
    {
        $this->navbar_title = $navbar_title;

        return $this;
    }

    public function getHeaderTitle(): ?string
    {
        return $this->header_title;
    }

    public function setHeaderTitle(?string $header_title): static
    {
        $this->header_title = $header_title;

        return $this;
    }
}
