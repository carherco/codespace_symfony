<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $meal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $diet;

    /**
     * @ORM\Column(type="integer")
     */
    private $prep_time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $foto;

    /**
     * @ORM\OneToMany(targetEntity=RecipeIngredient::class, mappedBy="recipe")
     */
    private $recipeIngredients;

    public function __construct()
    {
        $this->recipeIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMeal(): ?string
    {
        return $this->meal;
    }

    public function setMeal(string $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getDiet(): ?string
    {
        return $this->diet;
    }

    public function setDiet(string $diet): self
    {
        $this->diet = $diet;

        return $this;
    }

    public function getPrepTime(): ?int
    {
        return $this->prep_time;
    }

    public function setPrepTime(int $prep_time): self
    {
        $this->prep_time = $prep_time;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }


    /**
     * @return Collection|RecipeIngredient[]
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredients2(RecipeIngredient $recipeIngredients2): self
    {
        if (!$this->recipeIngredients2->contains($recipeIngredients2)) {
            $this->recipeIngredients2[] = $recipeIngredients2;
            $recipeIngredients2->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredients(RecipeIngredient $recipeIngredients2): self
    {
        if ($this->recipeIngredients2->removeElement($recipeIngredients2)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredients2->getRecipe() === $this) {
                $recipeIngredients2->setRecipe(null);
            }
        }

        return $this;
    }
}