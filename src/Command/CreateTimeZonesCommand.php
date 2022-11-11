<?php
/**
 * @author Manuel Aguirre
 */

declare(strict_types=1);

namespace Optime\TimeZone\Bundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Optime\TimeZone\Bundle\Entity\TimeZone;
use Optime\TimeZone\Bundle\Repository\TimeZoneRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function array_map;
use function dirname;
use function file_get_contents;
use function str_getcsv;
use const PHP_EOL;

/**
 * @author Manuel Aguirre
 */
#[AsCommand('optime:timezone:fill', 'Genera los registros en la bd')]
class CreateTimeZonesCommand extends Command
{
    public function __construct(
        private readonly TimeZoneRepository $repository,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (0 === count($this->repository->findAll())) {
            $data = $this->getCsvData();

            foreach ($data as $row) {
                $timeZone = new TimeZone(...$row);

                $this->entityManager->persist($timeZone);
            }

            $this->entityManager->flush();

        }

        $io->success("TimeZones creados con exito!!!");

        return Command::SUCCESS;
    }

    private function getCsvData(): array
    {
        $fileContent = file_get_contents(dirname(dirname(__DIR__)) . '/resources/timezones.csv');
        $rows = str_getcsv($fileContent, PHP_EOL);

        return array_map('str_getcsv', $rows);
    }
}