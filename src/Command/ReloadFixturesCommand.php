<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:reload-fixtures',
    description: 'Reload the base and fixtures',
)]
class ReloadFixturesCommand extends Command
{
    public function __construct(
        protected KernelInterface $kernel
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('force', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $force = $input->getOption('force');

        // Deny command execution if we are in prod mode and force is not passed
        if ((!$force || $force === '') && $this->kernel->getEnvironment() !== 'dev') {
            $io->error('Access denied. Pass option "--force" to force command execution in production env.');
            return Command::FAILURE;
        }

        $command = 'symfony console doctrine:database:drop --if-exists --force';
        exec($command);
        $io->success('Deletion of database');

        $command = 'symfony console doctrine:database:create --if-not-exists';
        exec($command);
        $io->success("Creation of new database");

        $command = 'symfony console doctrine:migrations:migrate --no-interaction';
        exec($command);
        $io->success('Migrations execution');

        $command = 'symfony console doctrine:fixtures:load -n --no-interaction';
        exec($command);
        $io->success('Fixtures loaded');
        
        $command = 'symfony console cache:clear';
        exec($command);
        $io->success('Cache deletion');

        $io->success('Operation done.');

        return Command::SUCCESS;
    }
}
