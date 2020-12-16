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

    /**
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="scale")
     */
    private $models;

    public function __construct()
    {
        $this->allowedScale = new ArrayCollection();
        $this->models = new ArrayCollection();
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

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setScale($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getScale() === $this) {
                $model->setScale(null);
            }
        }

        return $this;
    }
}
