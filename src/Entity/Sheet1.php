<?php

namespace App\Entity;

use App\Repository\Sheet1Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Sheet1Repository::class)]
class Sheet1
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cell = null;

    #[ORM\Column(length: 255)]
    private ?string $var_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCell(): ?string
    {
        return $this->cell;
    }

    public function setCell(string $cell): static
    {
        $this->cell = $cell;

        return $this;
    }

    public function getVarName(): ?string
    {
        return $this->var_name;
    }

    public function setVarName(string $var_name): static
    {
        $this->var_name = $var_name;

        return $this;
    }
}
