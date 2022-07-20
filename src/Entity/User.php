<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\ManyToOne(targetEntity: Professor::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private $professor;

    #[ORM\OneToMany(mappedBy: 'themecreator', targetEntity: Themes::class)]
    private $themes;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Agenda::class)]
    private $agendas;

    #[ORM\OneToMany(mappedBy: 'studycreator', targetEntity: Studies::class)]
    private $studies;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->agendas = new ArrayCollection();
        $this->studies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(){
        return $this->firstname.''.$this->lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
        //$roles = $this->roles;
        //$roles[] = 'ROLE_USER';
        //return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    /**
     * @return Collection<int, Themes>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Themes $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->setThemecreator($this);
        }

        return $this;
    }

    public function removeTheme(Themes $theme): self
    {
        if ($this->themes->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getThemecreator() === $this) {
                $theme->setThemecreator(null);
            }
        }

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
            $agenda->setStudent($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agendas->removeElement($agenda)) {
            // set the owning side to null (unless already changed)
            if ($agenda->getStudent() === $this) {
                $agenda->setStudent(null);
            }
        }

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
            $study->setStudycreator($this);
        }

        return $this;
    }

    public function removeStudy(Studies $study): self
    {
        if ($this->studies->removeElement($study)) {
            // set the owning side to null (unless already changed)
            if ($study->getStudycreator() === $this) {
                $study->setStudycreator(null);
            }
        }

        return $this;
    }
}
