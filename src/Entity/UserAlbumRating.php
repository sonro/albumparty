<?php

namespace App\Entity;

use App\Repository\UserAlbumRatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAlbumRatingRepository::class)
 */
class UserAlbumRating
{
	public const ONE_STAR = 20;
	public const TWO_STAR = 40;
	public const THREE_STAR = 60;
	public const FOUR_STAR = 80;
	public const FIVE_STAR = 100;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    /**
     * @ORM\Column(type="smallint")
     */
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
		if ($rating !== self::ONE_STAR
			&& $rating !== self::TWO_STAR
			&& $rating !== self::THREE_STAR
			&& $rating !== self::FOUR_STAR
			&& $rating !== self::FIVE_STAR
		) {
			throw new \InvalidArgumentException(
				"Rating must be a mupliple of 20 between 20 (1 star), and 100 (5 stars)"
			);
		}

        $this->rating = $rating;

        return $this;
    }
}
