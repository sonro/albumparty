<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist;

    /**
     * @ORM\Column(type="smallint")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePath;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $globalRating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wikipedia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $spotify;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @ORM\OneToMany(targetEntity=UserAlbumRating::class, mappedBy="album", orphanRemoval=true)
     */
    private $ratings;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getGlobalRating(): ?int
    {
        return $this->globalRating;
    }

    public function setGlobalRating(?int $globalRating): self
    {
        $this->globalRating = $globalRating;

        return $this;
    }

    public function getWikipedia(): ?string
    {
        return $this->wikipedia;
    }

    public function setWikipedia(?string $wikipedia): self
    {
        $this->wikipedia = $wikipedia;

        return $this;
    }

    public function getSpotify(): ?string
    {
        return $this->spotify;
    }

    public function setSpotify(?string $spotify): self
    {
        $this->spotify = $spotify;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * @return Collection|UserAlbumRating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(UserAlbumRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setAlbum($this);
        }

        return $this;
    }

    public function removeRating(UserAlbumRating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getAlbum() === $this) {
                $rating->setAlbum(null);
            }
        }

        return $this;
    }
}
