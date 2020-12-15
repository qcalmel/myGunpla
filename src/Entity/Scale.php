<?php

namespace App\Entity;

use App\Repository\ScaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScaleRepository::class)
 */
class Scale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Grade::class, inversedBy="scales")
     */
    private $allowedScale;

    public function __construct()
    {
        $this->allowedScale = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Grade[]
     */
    public function getAllowedScale(): Collection
    {
        return $this->allowedScale;
    }

    public function addAllowedScale(Grade $allowedScale): self
    {
        if (!$this->allowedScale->contains($allowedScale)) {
            $this->allowedScale[] = $allowedScale;
        }

        return $this;
    }

    public function removeAllowedScale(Grade $allowedScale): self
    {
        $this->allowedScale->removeElement($allowedScale);

        return $this;
    }
}
