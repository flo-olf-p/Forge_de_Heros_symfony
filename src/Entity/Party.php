<?php

namespace App\Entity;

use App\Repository\PartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
class Party
{
    #[Groups('character')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Groups('party')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[Groups('party')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;
    #[Groups('party')]
    #[ORM\Column]
    private ?int $maxSize = null;

    /**
     * @var Collection<int, User>
     */
    #[Groups('party')]
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'user_party')]
    private Collection $users;

    /**
     * @var Collection<int, Character>
     */
    #[Groups('party')]
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'party_character')]
    private Collection $characters;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxSize(): ?int
    {
        return $this->maxSize;
    }

    public function setMaxSize(int $maxSize): static
    {
        $this->maxSize = $maxSize;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addUserParty($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeUserParty($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->addPartyCharacter($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            $character->removePartyCharacter($this);
        }

        return $this;
    }
}
