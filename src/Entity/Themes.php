<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemesRepository::class)]
class Themes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'themes')]
    #[ORM\JoinColumn(nullable: false)]
    private $themecreator;

    #[ORM\ManyToMany(targetEntity: Studies::class, mappedBy: 'studytheme')]
    private $studies;

    public function __construct()
    {
        $this->studies = new ArrayCollection();
    }

    public function __toString(){
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getThemecreator(): ?User
    {
        return $this->themecreator;
    }

    public function setThemecreator(?User $themecreator): self
    {
        $this->themecreator = $themecreator;

        return $this;
    }

    /**
     * @return Collection<int, Studies>
     */
    public function getStudies(): Collection
    {
        return $this->studies;
    }

    public function addStudy(Studies $study): self
    {
        if (!$this->studies->contains($study)) {
            $this->studies[] = $study;
            $study->addStudytheme($this);
        }

        return $this;
    }

    public function removeStudy(Studies $study): self
    {
        if ($this->studies->removeElement($study)) {
            $study->removeStudytheme($this);
        }

        return $this;
    }
}
