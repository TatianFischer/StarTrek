<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 */
class Serie
{
    public static $_list_polices = array(
        'tos-police' => 'tos-police',
        'tng-police' => 'tng-police',
        'ds9-police' => 'ds9-police',
        'ent-police' => 'ent-police',
        'dis-police' => 'dis-police',
    );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Saison", mappedBy="serie", orphanRemoval=true)
     */
    private $saisons;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $police;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFilm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Film", mappedBy="serie")
     */
    private $films;

    /**
     * @ORM\ManyToMany(targetEntity=Personnage::class, mappedBy="series", cascade={"persist","remove"})
     */
    private $personnages;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $end;

    /**
     * @ORM\ManyToMany(targetEntity=Personnage::class, mappedBy="recurring")
     * @ORM\JoinTable(name="recurring_serie")
     */
    private $recurringPersonnages;

    public function __construct()
    {
        $this->saisons = new ArrayCollection();
        $this->films = new ArrayCollection();
        $this->personnages = new ArrayCollection();
        $this->recurringPersonnages = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Saison[]
     */
    public function getSaisons(): Collection
    {
        return $this->saisons;
    }

    public function addSaison(Saison $saison): self
    {
        if (!$this->saisons->contains($saison)) {
            $this->saisons[] = $saison;
            $saison->setSerie($this);
        }

        return $this;
    }

    public function removeSaison(Saison $saison): self
    {
        if ($this->saisons->contains($saison)) {
            $this->saisons->removeElement($saison);
            // set the owning side to null (unless already changed)
            if ($saison->getSerie() === $this) {
                $saison->setSerie(null);
            }
        }

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getPolice(): ?string
    {
        return $this->police;
    }

    public function setPolice(?string $police): self
    {
        $this->police = $police;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getIsFilm(): ?bool
    {
        return $this->isFilm;
    }

    public function setIsFilm(bool $isFilm): self
    {
        $this->isFilm = $isFilm;

        return $this;
    }

    /**
     * @return Collection|Film[]
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films[] = $film;
            $film->setSerie($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        if ($this->films->contains($film)) {
            $this->films->removeElement($film);
            // set the owning side to null (unless already changed)
            if ($film->getSerie() === $this) {
                $film->setSerie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Personnage[]
     */
    public function getPersonnages(): Collection
    {
        return $this->personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnages->contains($personnage)) {
            $this->personnages[] = $personnage;
            $personnage->addSeries($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->removeElement($personnage)) {
            $personnage->removeSeries($this);
        }

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(?\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection|Personnage[]
     */
    public function getRecurringPersonnages(): Collection
    {
        return $this->recurringPersonnages;
    }

    public function addRecurringPersonnage(Personnage $recurringPersonnage): self
    {
        if (!$this->recurringPersonnages->contains($recurringPersonnage)) {
            $this->recurringPersonnages[] = $recurringPersonnage;
            $recurringPersonnage->addRecurring($this);
        }

        return $this;
    }

    public function removeRecurringPersonnage(Personnage $recurringPersonnage): self
    {
        if ($this->recurringPersonnages->removeElement($recurringPersonnage)) {
            $recurringPersonnage->removeRecurring($this);
        }

        return $this;
    }
}
