<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonnageRepository::class)
 */
class Personnage
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
    private $actor;

    /**
     * @ORM\ManyToMany(targetEntity=Serie::class, inversedBy="personnages", cascade={"persist","remove"})
     */
    private $series;

    /**
     * @ORM\ManyToMany(targetEntity=Serie::class, inversedBy="recurringPersonnages", cascade={"persist","remove"})
     * @ORM\JoinTable(name="recurring_serie")
     */
    private $recurring;

    public function __construct()
    {
        $this->series = new ArrayCollection();
        $this->recurring = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName().' ('.$this->getActor().')';
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

    public function getActor(): ?string
    {
        return $this->actor;
    }

    public function setActor(string $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * @return Collection|Serie[]
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Serie $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series[] = $series;
        }

        return $this;
    }

    public function removeSeries(Serie $series): self
    {
        $this->series->removeElement($series);

        return $this;
    }

    /**
     * @return Collection|Serie[]
     */
    public function getRecurring(): Collection
    {
        return $this->recurring;
    }

    public function addRecurring(Serie $recurring): self
    {
        if (!$this->recurring->contains($recurring)) {
            $this->recurring[] = $recurring;
        }

        return $this;
    }

    public function removeRecurring(Serie $recurring): self
    {
        $this->recurring->removeElement($recurring);

        return $this;
    }
}
