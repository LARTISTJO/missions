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

    #[ORM\ManyToMany(targetEntity: Themes::class, inversedBy: 'studies')]
    private $studytheme;

    #[ORM\OneToMany(mappedBy: 'study', targetEntity: Agenda::class)]
    private $agendas;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'studies')]
    #[ORM\JoinColumn(nullable: false)]
    private $studycreator;

    public function __construct()
    {
        $this->studytheme = new ArrayCollection();
        $this->agendas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(){
        return $this->title;
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
     * @return Collection<int, Themes>
     */
    public function getStudytheme(): Collection
    {
        return $this->studytheme;
    }

    public function addStudytheme(Themes $studytheme): self
    {
        if (!$this->studytheme->contains($studytheme)) {
            $this->studytheme[] = $studytheme;
        }

        return $this;
    }

    public function removeStudytheme(Themes $studytheme): self
    {
        $this->studytheme->removeElement($studytheme);

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
}
