<?php

namespace App\Command;

use App\Domain\Factory\PartyFactory;
use App\Entity\Party;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreatePartyCommand extends Command
{
    protected static $defaultName = 'app:create-party';

	public function __construct(
		private PartyFactory $partyFactory,
		private EntityManagerInterface $entityManager,
	)
	{
		parent::__construct();	
	}

    protected function configure()
    {
        $this
            ->setDescription('Create the single party for initial use')
            ->addArgument('name', InputArgument::OPTIONAL, 'Party name')
            ->addArgument('interval', InputArgument::OPTIONAL, 'Days till new album generation')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name') ?? $io->ask("Party name");
        $interval = $input->getArgument('interval') ?? $io->ask("Days till new album generation");

		$party = $this->partyFactory->createParty($name, $interval);
		$this->entityManager->persist($party);
		$this->entityManager->flush();

        $io->success('Party Created');

        return Command::SUCCESS;
    }
}
