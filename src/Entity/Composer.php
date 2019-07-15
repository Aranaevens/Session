<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComposerRepository")
 */
class Composer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modul", mappedBy="composer")
     */
    private $modules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="composer")
     */
    private $sessions;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): self
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    /**
     * @return Collection|Modul[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Modul $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setComposer($this);
        }

        return $this;
    }

    public function removeModule(Modul $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getComposer() === $this) {
                $module->setComposer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setComposer($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getComposer() === $this) {
                $session->setComposer(null);
            }
        }

        return $this;
    }
}
