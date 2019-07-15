<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModulRepository")
 */
class Modul
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $intitule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Composer", inversedBy="modules")
     */
    private $composer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitule(): ?string
    {
        return $this->initule;
    }

    public function setInitule(string $initule): self
    {
        $this->initule = $initule;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getComposer(): ?Composer
    {
        return $this->composer;
    }

    public function setComposer(?Composer $composer): self
    {
        $this->composer = $composer;

        return $this;
    }
}
