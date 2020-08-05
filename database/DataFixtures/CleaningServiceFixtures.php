<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\CleaningService\Domain\Model\CleaningService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CleaningServiceFixtures extends Fixture
{
    public const VACUUMING = 'CLEANING_SERVICE.VACUUMING';
    public const WINDOW_CLEANING = 'CLEANING_SERVICE.WINDOW_CLEANING';
    public const CLEAN_THE_REFRIGERATOR = 'CLEANING_SERVICE.CLEAN_THE_REFRIGERATOR';

    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createVacuumingCleaningService();
        $this->createWindowCleaningCleaningService();
        $this->createCleanTheRefrigeratorCleaningService();

        $this->manager->flush();
    }

    private function createVacuumingCleaningService(): void
    {
        $fixture = new CleaningService('Vacuuming', 21);

        $this->manager->persist($fixture);
        $this->addReference(self::VACUUMING, $fixture);
    }

    private function createWindowCleaningCleaningService(): void
    {
        $fixture = new CleaningService('Window cleaning', 35);

        $this->manager->persist($fixture);
        $this->addReference(self::WINDOW_CLEANING, $fixture);
    }

    private function createCleanTheRefrigeratorCleaningService(): void
    {
        $fixture = new CleaningService('Clean the refrigerator', 50);

        $this->manager->persist($fixture);
        $this->addReference(self::CLEAN_THE_REFRIGERATOR, $fixture);
    }
}
