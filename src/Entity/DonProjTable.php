<?php

namespace App\Entity;

use App\Repository\DonProjTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonProjTableRepository::class)]
class DonProjTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $donproj_id = null;

    #[ORM\Column]
    private ?int $donateur_id = null;

    #[ORM\Column]
    private ?int $p1 = null;

    #[ORM\Column]
    private ?int $p2 = null;



    public function getDonProjId(): ?int
    {
        return $this->donproj_id;
    }

    public function getDonateur_Id(): ?int
    {
        return $this->donateur_id;
    }

    public function setDonateurId(int $donateur_id): static
    {
        $this->donateur_id = $donateur_id;

        return $this;
    }

    public function getP1(): ?int
    {
        return $this->p1;
    }

    public function setP1(int $p1): static
    {
        $this->p1 = $p1;

        return $this;
    }

    public function getP2(): ?int
    {
        return $this->p2;
    }

    public function setP2(int $p2): static
    {
        $this->p2 = $p2;

        return $this;
    }

}
