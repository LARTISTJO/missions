<?php

namespace App\Entity;

use App\Repository\AgendaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaRepository::class)]
class Agenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $informations;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $start;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $ending;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'agendas')]
    private $student;

    #[ORM\ManyToOne(targetEntity: Professor::class, inversedBy: 'agendas')]
    private $professor;

    #[ORM\ManyToOne(targetEntity: Studies::class, inversedBy: 'agendas')]
    private $study;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnding(): ?\DateTimeInterface
    {
        return $this->ending;
    }

    public function setEnding(?\DateTimeInterface $ending): self
    {
        $this->ending = $ending;

        return $this;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): self
    {
        $this->professor = $professor;

        return $this;
    }

    public function getStudy(): ?Studies
    {
        return $this->study;
    }

    public function setStudy(?Studies $study): self
    {
        $this->study = $study;

        return $this;
    }
}
