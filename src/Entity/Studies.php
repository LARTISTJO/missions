<?php

namespace App\Entity;

use App\Repository\StudiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudiesRepository::class)]
class Studies
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

    #[ORM\OneToMany(mappedBy: 'study', targetEntity: Agenda::class)]
    private $agendas;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'studies')]
    #[ORM\JoinColumn(nullable: false)]
    private $studycreator;

    #[ORM\ManyToOne(targetEntity: Themes::class, inversedBy: 'studies')]
    #[ORM\JoinColumn(nullable: false)]
    private $studytheme;

    public function __construct()
    {
        $this->agendas = new ArrayCollection();
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

    /**
     * @return Collection<int, Agenda>
     */
    public function getAgendas(): Collection
    {
        return $this->agendas;
    }

    public function addAgenda(Agenda $agenda): self
    {
        if (!$this->agendas->contains($agenda)) {
            $this->agendas[] = $agenda;
            $agenda->setStudy($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agendas->removeElement($agenda)) {
            // set the owning side to null (unless already changed)
            if ($agenda->getStudy() === $this) {
                $agenda->setStudy(null);
            }
        }

        return $this;
    }

    public function getStudycreator(): ?User
    {
        return $this->studycreator;
    }

    public function setStudycreator(?User $studycreator): self
    {
        $this->studycreator = $studycreator;

        return $this;
    }

    public function getStudytheme(): ?Themes
    {
        return $this->studytheme;
    }

    public function setStudytheme(?Themes $studytheme): self
    {
        $this->studytheme = $studytheme;

        return $this;
    }

}
