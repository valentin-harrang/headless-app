<?php

namespace App\Command;

use App\Service\NewsLequipeService;
use Constants;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportNewsCommand extends Command
{
    protected KernelInterface $kernel;

    protected NewsLequipeService $lequipeService;

    public function __construct(KernelInterface $kernel, NewsLequipeService $lequipeService)
    {
        parent::__construct();

        $this->kernel         = $kernel;
        $this->lequipeService = $lequipeService;
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $limitArgument =
            $input->getArgument('limit') ===
            null ? Constants::NEWS_FEED_DEFAULT_LIMIT : (int)$input->getArgument('limit');

        $this->lequipeService->getRemoteNewsAndInsertThemInDatabase($limitArgument);

        $output->writeln('News successfully imported (' . $limitArgument . ') !');

        return Command::SUCCESS;
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    protected function configure(): void
    {
        $this
            ->setName('import-news')
            ->setHelp('This command allows you to import news')
            ->addArgument('limit', InputArgument::OPTIONAL, 'News limit');
    }

    protected function runCommand(string $name, array $arguments = []): void
    {
        $arguments['command'] = $name;

        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput($arguments);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $output->fetch();
    }
}
