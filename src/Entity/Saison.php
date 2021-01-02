<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SaisonRepository")
 */
class Saison
{
    public static $_list_colors = array(
        'yellow-tos' => 'yellow-tos',
        'blue-tos' => 'blue-tos',
        'red-tos' => 'red-tos',
        'orange-tas' => 'orange-tas',
        'yellow-tng' => 'yellow-tng',
        'blue-tng' => 'blue-tng',
        'red-tng' => 'red-tng',
        'yellow-ds9' => 'yellow-ds9',
        'green-ds9' => 'green-ds9',
        'red-ds9' => 'red-ds9',
        'yellow-voy' => 'yellow-voy',
        'red-voy' => 'red-voy',
        'green-voy' => 'green-voy',
        'yellow-pic' => 'yellow-pic',
    );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="saisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="saison", orphanRemoval=true)
     */
    private $episodes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getSerieCode()
    {
        return $this->serie->getCode();
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setSaison($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getSaison() === $this) {
                $episode->setSaison(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function __toString()
    {
        return $this->getSerieCode().' saison '.$this->getNumber();
    }
}
