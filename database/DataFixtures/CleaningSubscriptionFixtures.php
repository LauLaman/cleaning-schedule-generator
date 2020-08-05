<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\CleaningService\Domain\Model\CleaningService;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use App\Location\Domain\Model\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CleaningSubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public const VACUUMING = 'CLEANING_SUBSCRIPTION.VACUUMING';
    public const WINDOW_CLEANING = 'CLEANING_SUBSCRIPTION.WINDOW_CLEANING';
    public const CLEAN_THE_REFRIGERATOR = 'CLEANING_SUBSCRIPTION.CLEAN_THE_REFRIGERATOR';

    private ObjectManager $manager;

    public function getDependencies(): array
    {
        return [
            CleaningServiceFixtures::class,
            LocationFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createLeviySubscriptions();

        $this->manager->flush();
    }

    private function createLeviySubscriptions(): void
    {
        $this->createLeviyVacuumingSubscription();
        $this->createLeviyWindowCleaningSubscription();
        $this->createLeviyCleanTheRefrigeratorSubscription();
    }

    private function createLeviyVacuumingSubscription(): void
    {
        /** @var Location $location */
        $location = $this->getReference(LocationFixtures::LEVIY);

        /** @var CleaningService $cleaningService */
        $cleaningService = $this->getReference(CleaningServiceFixtures::VACUUMING);

        $fixture = new CleaningSubscription($location, $cleaningService);

        $this->manager->persist($fixture);
        $this->addReference(self::VACUUMING, $fixture);
    }

    private function createLeviyWindowCleaningSubscription(): void
    {
        /** @var Location $location */
        $location = $this->getReference(LocationFixtures::LEVIY);

        /** @var CleaningService $cleaningService */
        $cleaningService = $this->getReference(CleaningServiceFixtures::WINDOW_CLEANING);

        $fixture = new CleaningSubscription($location, $cleaningService);

        $this->manager->persist($fixture);
        $this->addReference(self::WINDOW_CLEANING, $fixture);
    }

    private function createLeviyCleanTheRefrigeratorSubscription(): void
    {
        /** @var Location $location */
        $location = $this->getReference(LocationFixtures::LEVIY);

        /** @var CleaningService $cleaningService */
        $cleaningService = $this->getReference(CleaningServiceFixtures::CLEAN_THE_REFRIGERATOR);

        $fixture = new CleaningSubscription($location, $cleaningService);

        $this->manager->persist($fixture);
        $this->addReference(self::CLEAN_THE_REFRIGERATOR, $fixture);
    }
}
