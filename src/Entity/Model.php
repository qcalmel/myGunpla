<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
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
    private $version;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPart;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $gradeNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codeJAN;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="model")
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity=Unit::class, inversedBy="models")
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity=Grade::class, inversedBy="models")
     */
    private $grade;

    /**
     * @ORM\ManyToMany(targetEntity=ModelColor::class, inversedBy="modelsPrimary")
     * @ORM\JoinTable(name="model_primaryColor")
     */
    private $primaryColor;

    /**
     * @ORM\ManyToMany(targetEntity=ModelColor::class, inversedBy="modelsSecondary")
     * @ORM\JoinTable(name="model_secondaryColor")
     */
    private $secondaryColor;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="models")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Scale::class, inversedBy="models")
     */
    private $scale;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->unit = new ArrayCollection();
        $this->primaryColor = new ArrayCollection();
        $this->secondaryColor = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNbPart(): ?int
    {
        return $this->nbPart;
    }

    public function setNbPart(?int $nbPart): self
    {
        $this->nbPart = $nbPart;

        return $this;
    }

    public function getGradeNumber(): ?string
    {
        return $this->gradeNumber;
    }

    public function setGradeNumber(?string $gradeNumber): self
    {
        $this->gradeNumber = $gradeNumber;

        return $this;
    }

    public function getCodeJAN(): ?int
    {
        return $this->codeJAN;
    }

    public function setCodeJAN(?int $codeJAN): self
    {
        $this->codeJAN = $codeJAN;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setModel($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getModel() === $this) {
                $image->setModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Unit[]
     */
    public function getUnit(): Collection
    {
        return $this->unit;
    }

    public function addUnit(Unit $unit): self
    {
        if (!$this->unit->contains($unit)) {
            $this->unit[] = $unit;
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        $this->unit->removeElement($unit);

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return Collection|ModelColor[]
     */
    public function getPrimaryColor(): Collection
    {
        return $this->primaryColor;
    }

    public function addPrimaryColor(ModelColor $primaryColor): self
    {
        if (!$this->primaryColor->contains($primaryColor)) {
            $this->primaryColor[] = $primaryColor;
        }

        return $this;
    }

    public function removePrimaryColor(ModelColor $primaryColor): self
    {
        $this->primaryColor->removeElement($primaryColor);

        return $this;
    }

    /**
     * @return Collection|ModelColor[]
     */
    public function getSecondaryColor(): Collection
    {
        return $this->secondaryColor;
    }

    public function addSecondaryColor(ModelColor $secondaryColor): self
    {
        if (!$this->secondaryColor->contains($secondaryColor)) {
            $this->secondaryColor[] = $secondaryColor;
        }

        return $this;
    }

    public function removeSecondaryColor(ModelColor $secondaryColor): self
    {
        $this->secondaryColor->removeElement($secondaryColor);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getScale(): ?Scale
    {
        return $this->scale;
    }

    public function setScale(?Scale $scale): self
    {
        $this->scale = $scale;

        return $this;
    }
}
