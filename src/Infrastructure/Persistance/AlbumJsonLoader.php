<?php

namespace App\Infrastructure\Persistance;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;

class AlbumJsonLoader
{
	public function __construct(
		private EntityManagerInterface $entityManager,
		private AlbumRepository $albumRepository,
	)
	{}

	public function loadFromFile(string $filename): array
	{
		$json = file_get_contents($filename);
		$data = $this->deserializeJson($json);

		return	$this->updateDatabase($data);
	}

	private function updateDatabase(array $data): array
	{
		$existingAlbums = $this->albumRepository->findAll();
		foreach ($data as $id => $albumData) {
			$eId = $id - 1;
			if (isset($existingAlbums[$eId])) {
				$this->hydrateAlbum($existingAlbums[$eId], $albumData);
			} else {
				$album = new Album();
				$this->hydrateAlbum($album, $albumData);
				$this->entityManager->persist($album);
			}
		}
		$this->entityManager->flush();	

		return $existingAlbums;
	}

	private function hydrateAlbum(Album $album, array $data)
	{
		$this->changeIfUpdated($album, $data, "Artist", "artist");
		$this->changeIfUpdated($album, $data, "Title", "title");
		$this->changeIfUpdated($album, $data, "ImagePath", "imagePath");
		$this->changeIfUpdated($album, $data, "Spotify", "spotify");
		$this->changeIfUpdated($album, $data, "Wikipedia", "wikipedia");
		$this->changeIfUpdated($album, $data, "Youtube", "youtube");
		$this->changeIfUpdated($album, $data, "Year", "year");
	}

	private function changeIfUpdated(Album $album, array $data, string $Prop, string $prop)
	{
		$getter = "get".$Prop;
		$setter = "set".$Prop;
		if (call_user_func([$album, $getter]) !== $data[$prop]) {
			call_user_func([$album, $setter], $data[$prop]);
		}
	}

	private function deserializeJson(string $json)
	{
		$albums = json_decode($json, true);

		return $albums;
	}
}
