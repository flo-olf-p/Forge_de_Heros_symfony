<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('character')]
    private ?int $id = null;
    #[Groups('character')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[Groups('character')]
    #[ORM\Column]
    private ?int $level = null;
    #[Groups('character')]
    #[ORM\Column]
    #[Constraints\GreaterThanOrEqual(8)]
    #[Constraints\LessThanOrEqual(15)]
    private ?int $strength = null;
    #[Groups('character')]
    #[ORM\Column]
    #[Constraints\GreaterThanOrEqual(8)]
    #[Constraints\LessThanOrEqual(15)]
    private ?int $dexterity = null;
    #[Groups('character')]
    #[ORM\Column]
    #[Constraints\GreaterThanOrEqual(8)]
    #[Constraints\LessThanOrEqual(15)]
    private ?int $constitution = null;
    #[Groups('character')]
    #[ORM\Column]
    #[Constraints\GreaterThanOrEqual(8)]
    #[Constraints\LessThanOrEqual(15)]
    private ?int $intelligence = null;
    #[Groups('character')]
    #[ORM\Column]
    #[Constraints\GreaterThanOrEqual(8)]
    #[Constraints\LessThanOrEqual(15)]
    private ?int $wisdom = null;
    #[Groups('character')]
    #[ORM\Column]
    #[Constraints\GreaterThanOrEqual(8)]
    #[Constraints\LessThanOrEqual(15)]
    private ?int $charisma = null;
    #[Groups('character')]
    #[ORM\Column]
    private ?int $healthPoints = null;

    #[Groups('character')]
    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Party>
     */
    #[Ignore]
    #[ORM\ManyToMany(targetEntity: Party::class, inversedBy: 'characters')]
    private Collection $party_character;
    #[Groups('character')]
    #[ORM\ManyToOne(inversedBy: 'character')]
    private ?Race $race = null;
    #[Groups('character')]
    #[ORM\ManyToOne(inversedBy: 'class_characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacterClass $class_character = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $AvatarFileName = null;

    public function __construct()
    {
        $this->party_character = new ArrayCollection();
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): static
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDexterity(): ?int
    {
        return $this->dexterity;
    }

    public function setDexterity(int $dexterity): static
    {
        $this->dexterity = $dexterity;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): static
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): static
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getWisdom(): ?int
    {
        return $this->wisdom;
    }

    public function setWisdom(int $wisdom): static
    {
        $this->wisdom = $wisdom;

        return $this;
    }

    public function getCharisma(): ?int
    {
        return $this->charisma;
    }

    public function setCharisma(int $charisma): static
    {
        $this->charisma = $charisma;

        return $this;
    }

    public function getHealthPoints(): ?int
    {
        return $this->healthPoints;
    }

    public function setHealthPoints(int $healthPoints): static
    {
        $this->healthPoints = $healthPoints;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getPartyCharacter(): Collection
    {
        return $this->party_character;
    }

    public function addPartyCharacter(Party $partyCharacter): static
    {
        if (!$this->party_character->contains($partyCharacter)) {
            $this->party_character->add($partyCharacter);
        }

        return $this;
    }

    public function removePartyCharacter(Party $partyCharacter): static
    {
        $this->party_character->removeElement($partyCharacter);

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getClassCharacter(): ?CharacterClass
    {
        return $this->class_character;
    }

    public function setClassCharacter(?CharacterClass $class_character): static
    {
        $this->class_character = $class_character;

        return $this;
    }


    public function calculateHealthPoints(): ?int
    {
        if($this->getClassCharacter() !== null && $this->getClassCharacter()->getHealthDice() !== null)
        {
            return $this->getClassCharacter()->getHealthDice() + floor(($this->getConstitution() - 10) / 2);
        }
        return floor(($this->getConstitution() - 10) / 2);
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateHealthPoints(): void
    {
        $this->healthPoints = $this->calculateHealthPoints();
    }

    public function checkStatsPoints(): bool
    {
        $baseStats = 48;
        $availablePoints = 27;
        $totalStats =  $this->getStrength() + $this->getDexterity() + $this->getConstitution() + $this->getIntelligence() + $this->getWisdom() + $this->getCharisma();

        return ($totalStats - $baseStats) > $availablePoints;
    }

    // This function is called at the submission of a form
    #[Constraints\Callback]
    public function validateStatsPoints(ExecutionContextInterface $context, $payload): void
    {
        if ($this->checkStatsPoints())
        {
            $context->buildViolation('You attributed too much stats points to your character (over 27). You must remove some...')
                ->addViolation();
        }
    }

    public function getAvatarFileName(): ?string
    {
        return $this->AvatarFileName;
    }

    public function setAvatarFileName(?string $AvatarFileName): self
    {
        $this->AvatarFileName = $AvatarFileName;

        return $this;
    }
}
