<?php

namespace App\Entity;

use App\Repository\CharacterClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterClassRepository::class)]
class CharacterClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $healthDice = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'characterClasses')]
    private Collection $skill_characterClass;

    public function __construct()
    {
        $this->skill_characterClass = new ArrayCollection();
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

    public function getHealthDice(): ?int
    {
        return $this->healthDice;
    }

    public function setHealthDice(int $healthDice): static
    {
        $this->healthDice = $healthDice;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkillCharacterClass(): Collection
    {
        return $this->skill_characterClass;
    }

    public function addSkillCharacterClass(Skill $skillCharacterClass): static
    {
        if (!$this->skill_characterClass->contains($skillCharacterClass)) {
            $this->skill_characterClass->add($skillCharacterClass);
        }

        return $this;
    }

    public function removeSkillCharacterClass(Skill $skillCharacterClass): static
    {
        $this->skill_characterClass->removeElement($skillCharacterClass);

        return $this;
    }
}
