<?php

namespace App\Domain\Factory;

use App\Entity\Party;
use App\Repository\AlbumRepository;

class PartyFactory
{
	public function __construct(private AlbumRepository $albumRepository)
	{ }

	public function createParty(string $name, int $interval): Party
	{
		$party = new Party();
		$party->setName($name);
		$party->setInterval($interval);
		$party->setDaysTillInterval($interval);

		$albums = $this->generateAlbumList();
		$party->setCurrentAlbum(array_pop($albums));
		$party->setAlbumsLeft($albums);

		return $party;
	}

	/**
	 * @return Album[]
	 */
	protected function generateAlbumList(): array
	{
		$albums = $this->albumRepository->findAll();
		shuffle($albums);
		return $albums;
	}
}
