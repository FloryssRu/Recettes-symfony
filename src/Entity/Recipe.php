<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $preparationTime = null;

    #[ORM\Column]
    private ?bool $isVegetarian = null;

    #[ORM\Column]
    private ?bool $isVegan = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(
        targetEntity: Step::class,
        mappedBy: 'recipe',
        orphanRemoval: true,
        cascade: ['persist']
    )]
    private Collection $steps;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(
        targetEntity: Ingredient::class,
        mappedBy: 'recipe',
        orphanRemoval: true,
        cascade: ['persist']
    )]
    private Collection $ingredients;

    /**
     * @var Collection<int, Season>
     */
    #[ORM\ManyToMany(targetEntity: Season::class, mappedBy: 'recipes')]
    private Collection $seasons;

    /**
     * @var Collection<int, RecipeType>
     */
    #[ORM\ManyToMany(targetEntity: RecipeType::class, mappedBy: 'recipes')]
    private Collection $types;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likedRecipes')]
    private Collection $likedUsers;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->seasons = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->likedUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPreparationTime(): ?int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(?int $preparationTime): static
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function isVegetarian(): ?bool
    {
        return $this->isVegetarian;
    }

    public function setVegetarian(bool $isVegetarian): static
    {
        $this->isVegetarian = $isVegetarian;

        return $this;
    }

    public function isVegan(): ?bool
    {
        return $this->isVegan;
    }

    public function setVegan(bool $isVegan): static
    {
        $this->isVegan = $isVegan;

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->addRecipe($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->seasons->removeElement($season)) {
            $season->removeRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeType>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(RecipeType $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->addRecipe($this);
        }

        return $this;
    }

    public function removeType(RecipeType $type): static
    {
        if ($this->types->removeElement($type)) {
            $type->removeRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikedUsers(): Collection
    {
        return $this->likedUsers;
    }

    public function addLikedUser(User $likedUser): static
    {
        if (!$this->likedUsers->contains($likedUser)) {
            $this->likedUsers->add($likedUser);
            $likedUser->addLikedRecipe($this);
        }

        return $this;
    }

    public function removeLikedUser(User $likedUser): static
    {
        if ($this->likedUsers->removeElement($likedUser)) {
            $likedUser->removeLikedRecipe($this);
        }

        return $this;
    }
}
