<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Form\CategoryType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

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

    //ajout d'un attribut $programs (au pluriel) et son annotation
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program", mappedBy="category")
     */
    private $programs;

    //ajout du constructeur avec, dedans, l'initialisation de l'attribut $programs à un ArrayCollection
    public function __construct()

    {
        $this->programs = new ArrayCollection();
    }

    //ajout du *getter* de cet attribut
    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    //ajout d’une nouvelle méthode pour associer une nouvelle série à une catégorie
    /**
     * param Program $program
     * @return Category
     */
    public function addProgram(Program $program): self

    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setCategory($this);
        }
        return $this;
    }

    //ajout d’une nouvelle méthode pour supprimer l’association d’une série
    /**
     * @param Program $program
     * @return Category
     */
    public function removeProgram(Program $program): self

    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
            // set the owning side to null (unless already changed)
            if ($program->getCategory() === $this) {
                $program->setCategory(null);
            }
        }
        return $this;
    }

    public function add(string $string)
    {
    }
}
