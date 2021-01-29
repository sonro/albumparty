<?php

namespace App\Command;

use App\Infrastructure\Persistance\AlbumJsonLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadAlbumDataCommand extends Command
{
    protected static $defaultName = 'app:load-album-data';

	public function __construct(
		private AlbumJsonLoader $loader,
		private string $defaultAlbumJsonFile,
	) {
		parent::__construct();
	}

    protected function configure()
    {
        $this
            ->setDescription('Import and update album database from json file')
			->addArgument('file', InputArgument::OPTIONAL, 'Custom json file', $this->defaultAlbumJsonFile)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /* $io = new SymfonyStyle($input, $output); */

		$this->loader->loadFromFile($input->getArgument('file'));

        /* $io->success('Database updated'); */

        return Command::SUCCESS;
    }
}
