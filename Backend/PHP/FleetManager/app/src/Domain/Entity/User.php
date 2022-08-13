<?php

namespace Fulll\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fulll\App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Assert\NotBlank()]
    #[Assert\Email()]
    #[Assert\Type('string')]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[ORM\Column(type: 'string', length: 25, unique: true)]
    private string $username;

    #[Assert\Type('string')]
    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Fleet::class, cascade: ['persist', 'remove'])]
    private ?Fleet $fleet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(?Fleet $fleet): self
    {
        $this->fleet = $fleet;

        return $this;
    }
}
