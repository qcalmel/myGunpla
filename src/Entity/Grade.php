<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
//Todo Ajouter sub grade
/**
 * @ORM\Entity(repositoryClass=GradeRepository::class)
 */
class Grade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $nameShort;

    /**
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="grade")
     */
    private $models;

    /**
     * @ORM\ManyToMany(targetEntity=Scale::class, inversedBy="grades")
     */
    private $allowed_scales;

    /**
     * @ORM\ManyToOne(targetEntity=Picture::class,cascade={"persist"})
     */
    private $logo;


    public function __construct()
    {
        $this->models = new ArrayCollection();
        $this->allowed_scales = new ArrayCollection();
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

    public function getNameShort(): ?string
    {
        return $this->nameShort;
    }

    public function setNameShort(?string $nameShort): self
    {
        $this->nameShort = $nameShort;

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
            $model->setGrade($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getGrade() === $this) {
                $model->setGrade(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Scale[]
     */
    public function getAllowedScales(): Collection
    {
        return $this->allowed_scales;
    }

    public function addAllowedScale(Scale $allowedScale): self
    {
        if (!$this->allowed_scales->contains($allowedScale)) {
            $this->allowed_scales[] = $allowedScale;
        }

        return $this;
    }

    public function removeAllowedScale(Scale $allowedScale): self
    {
        $this->allowed_scales->removeElement($allowedScale);

        return $this;
    }

    public function getLogo(): ?Picture
    {
        return $this->logo;
    }

    public function setLogo(?Picture $logo): self
    {
        $this->logo = $logo;

        return $this;
    }


}
