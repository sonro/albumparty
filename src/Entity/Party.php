<?php

namespace App\Entity;

use App\Repository\PartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartyRepository::class)
 */
class Party
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
     * @ORM\Column(type="smallint")
     */
    private $interval;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $currentAlbum;

    /**
     * @ORM\ManyToMany(targetEntity=Album::class)
	 * @ORM\JoinTable(name="party_albums_done")
     */
    private $albumsDone;

    /**
     * @ORM\ManyToMany(targetEntity=Album::class)
	 * @ORM\JoinTable(name="party_albums_left")
     */
    private $albumsLeft;

    /**
     * @ORM\Column(type="smallint")
     */
    private $daysTillInterval;

    public function __construct()
    {
        $this->albumsDone = new ArrayCollection();
        $this->albumsLeft = new ArrayCollection();
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

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function getCurrentAlbum(): ?Album
    {
        return $this->currentAlbum;
    }

    public function setCurrentAlbum(?Album $currentAlbum): self
    {
        $this->currentAlbum = $currentAlbum;

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbumsDone(): Collection
    {
        return $this->albumsDone;
    }

    public function addAlbumsDone(Album $albumDone): self
    {
        if (!$this->albumsDone->contains($albumDone)) {
            $this->albumsDone[] = $albumDone;
        }

        return $this;
    }

    public function removeAlbumsDone(Album $albumDone): self
    {
        $this->albumsDone->removeElement($albumDone);

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbumsLeft(): Collection
    {
        return $this->albumsLeft;
    }

    /**
     * @return Album[]
     */
	public function setAlbumsLeft(array $albums): self
	{
		$this->albumsLeft = new ArrayCollection($albums);
		return $this;
	}

    public function addAlbumsLeft(Album $albumLeft): self
    {
        if (!$this->albumsLeft->contains($albumLeft)) {
            $this->albumsLeft[] = $albumLeft;
        }

        return $this;
    }

    public function removeAlbumsLeft(Album $albumLeft): self
    {
        $this->albumsLeft->removeElement($albumLeft);

        return $this;
    }

	public function nextAlbum(): Album
	{
		$this->albumsDone[] = $this->currentAlbum;
		$this->currentAlbum = array_pop($this->albumsLeft);
 
		return $this->currentAlbum;
	}

    public function getDaysTillInterval(): ?int
    {
        return $this->daysTillInterval;
    }

    public function setDaysTillInterval(int $daysTillInterval): self
    {
        $this->daysTillInterval = $daysTillInterval;

        return $this;
    }
}
