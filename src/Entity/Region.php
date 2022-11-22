<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $regionName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegionName(): ?string
    {
        return $this->regionName;
    }

    public function setRegionName(string $regionName): self
    {
        $this->regionName = $regionName;

        return $this;
    }
}
