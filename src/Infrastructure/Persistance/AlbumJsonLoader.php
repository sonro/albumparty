<?php

namespace App\Infrastructure\Persistance;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class AlbumJsonLoader
{
	public function __construct(
		private EntityManagerInterface $entityManager,
		private AlbumRepository $albumRepository,
		private LoggerInterface $persistanceLogger,
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
		$this->updateManagedArrayWithNewData($existingAlbums, $data);
		$this->entityManager->flush();	
		
		return $existingAlbums;
	}

	private function updateManagedArrayWithNewData(array $existingAlbums, array $data)
	{
		$idDiff = $existingAlbums[0]->getId();
		foreach ($data as $id => $albumData) {
			$exIndex = $id - $idDiff;
			if (isset($existingAlbums[$exIndex])) {
				if ($existingAlbums[$exIndex]->getId() !== $id) {
					$this->logIdError($existingAlbums[$exIndex], $id);
				} else {
					$this->hydrateAlbum($existingAlbums[$exIndex], $albumData);
				}
			} else {
				$album = new Album();
				$this->hydrateAlbum($album, $albumData);
				$this->entityManager->persist($album);
			}
		}
	}


	private function logIdError(Album $existing, $jsonId): void
	{
		$context = [
			"dbId" => $existing->getId(),
			"jsonId" => $jsonId
		];
		$this->persistanceLogger->error(
			"Album ID mismatch between json file and database", 
			$context
		);
	}

	private function hydrateAlbum(Album $album, array $data): void
	{
		$this->changeIfUpdated($album, $data, "Artist", "artist");
		$this->changeIfUpdated($album, $data, "Title", "title");
		$this->changeIfUpdated($album, $data, "ImagePath", "imagePath");
		$this->changeIfUpdated($album, $data, "Spotify", "spotify");
		$this->changeIfUpdated($album, $data, "Wikipedia", "wikipedia");
		$this->changeIfUpdated($album, $data, "Youtube", "youtube");
		$this->changeIfUpdated($album, $data, "Year", "year");
	}

	private function changeIfUpdated(Album $album, array $data, string $Prop, string $prop): void
	{
		$getter = "get".$Prop;
		$setter = "set".$Prop;
		$existingvalue = call_user_func([$album, $getter]);
		$newValue = $data[$prop];
		if ($existingvalue !== $newValue) {
			$context = [
				"albumId" => $album->getId(),
				"property" => $prop,
				"from" => $existingvalue,
				"to" => $newValue,
			];
			$this->persistanceLogger->debug("Album data updated", $context);
			call_user_func([$album, $setter], $data[$prop]);
		}
	}

	private function deserializeJson(string $json): array
	{
		$albums = json_decode($json, true);

		return $albums;
	}
}
