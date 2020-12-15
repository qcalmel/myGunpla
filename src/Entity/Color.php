<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Model::class, mappedBy="primaryColor")
     */
    private $modelsPrimary;

    /**
     * @ORM\ManyToMany(targetEntity=Model::class, mappedBy="secondaryColor")
     */
    private $modelsSecondary;

    public function __construct()
    {
        $this->modelsPrimary = new ArrayCollection();
        $this->modelsSecondary = new ArrayCollection();
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
     * @return Collection|Model[]
     */
    public function getModelsPrimary(): Collection
    {
        return $this->modelsPrimary;
    }

    public function addModelsPrimary(Model $modelsPrimary): self
    {
        if (!$this->modelsPrimary->contains($modelsPrimary)) {
            $this->modelsPrimary[] = $modelsPrimary;
            $modelsPrimary->addPrimaryColor($this);
        }

        return $this;
    }

    public function removeModelsPrimary(Model $modelsPrimary): self
    {
        if ($this->modelsPrimary->removeElement($modelsPrimary)) {
            $modelsPrimary->removePrimaryColor($this);
        }

        return $this;
    }

    /**
     * @return Collection|Model[]
     */
    public function getModelsSecondary(): Collection
    {
        return $this->modelsSecondary;
    }

    public function addModelsSecondary(Model $modelsSecondary): self
    {
        if (!$this->modelsSecondary->contains($modelsSecondary)) {
            $this->modelsSecondary[] = $modelsSecondary;
            $modelsSecondary->addSecondaryColor($this);
        }

        return $this;
    }

    public function removeModelsSecondary(Model $modelsSecondary): self
    {
        if ($this->modelsSecondary->removeElement($modelsSecondary)) {
            $modelsSecondary->removeSecondaryColor($this);
        }

        return $this;
    }
}
