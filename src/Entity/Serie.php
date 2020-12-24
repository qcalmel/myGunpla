<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie
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
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $nameShort;

    /**
     * @ORM\ManyToMany(targetEntity=Unit::class, mappedBy="serie")
     */
    private $units;

    /**
     * @ORM\ManyToOne(targetEntity=Era::class, inversedBy="series")
     */
    private $era;

    /**
     * @ORM\ManyToOne(targetEntity=SerieType::class, inversedBy="series")
     */
    private $serieType;

    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="series")
     */
    private $mainSerie;

    /**
     * @ORM\OneToMany(targetEntity=Serie::class, mappedBy="mainSerie")
     */
    private $series;

    public function __construct()
    {
        $this->units = new ArrayCollection();
        $this->series = new ArrayCollection();
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
     * @return Collection|Unit[]
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): self
    {
        if (!$this->units->contains($unit)) {
            $this->units[] = $unit;
            $unit->addSerie($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        if ($this->units->removeElement($unit)) {
            $unit->removeSerie($this);
        }

        return $this;
    }

    public function getEra(): ?Era
    {
        return $this->era;
    }

    public function setEra(?Era $era): self
    {
        $this->era = $era;

        return $this;
    }

    public function getSerieType(): ?SerieType
    {
        return $this->serieType;
    }

    public function setSerieType(?SerieType $serieType): self
    {
        $this->serieType = $serieType;

        return $this;
    }

    public function getMainSerie(): ?self
    {
        return $this->mainSerie;
    }

    public function setMainSerie(?self $mainSerie): self
    {
        $this->mainSerie = $mainSerie;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(self $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series[] = $series;
            $series->setMainSerie($this);
        }

        return $this;
    }

    public function removeSeries(self $series): self
    {
        if ($this->series->removeElement($series)) {
            // set the owning side to null (unless already changed)
            if ($series->getMainSerie() === $this) {
                $series->setMainSerie(null);
            }
        }

        return $this;
    }
}
