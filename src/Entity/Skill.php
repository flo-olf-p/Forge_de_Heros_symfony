<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, CharacterClass>
     */
    #[ORM\ManyToMany(targetEntity: CharacterClass::class, mappedBy: 'skill_characterClass')]
    private Collection $characterClasses;

    public function __construct()
    {
        $this->characterClasses = new ArrayCollection();
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

    /**
     * @return Collection<int, CharacterClass>
     */
    public function getCharacterClasses(): Collection
    {
        return $this->characterClasses;
    }

    public function addCharacterClass(CharacterClass $characterClass): static
    {
        if (!$this->characterClasses->contains($characterClass)) {
            $this->characterClasses->add($characterClass);
            $characterClass->addSkillCharacterClass($this);
        }

        return $this;
    }

    public function removeCharacterClass(CharacterClass $characterClass): static
    {
        if ($this->characterClasses->removeElement($characterClass)) {
            $characterClass->removeSkillCharacterClass($this);
        }

        return $this;
    }
}
