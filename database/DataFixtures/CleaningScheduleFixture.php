<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\CleaningSchedule\Domain\Model\CleaningSchedule;
use App\CleaningSchedule\Domain\Model\MonthlyCleaningSchedule;
use App\CleaningSchedule\Domain\Model\WeeklyCleaningSchedule;
use App\CleaningSchedule\Domain\ValueObject\MonthlySchedule;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CleaningScheduleFixture extends Fixture implements DependentFixtureInterface
{
    public const VACUUMING = 'CLEANING_SCHEDULE.VACUUMING';
    public const WINDOW_CLEANING = 'CLEANING_SCHEDULE.WINDOW_CLEANING';
    public const CLEAN_THE_REFRIGERATOR = 'CLEANING_SCHEDULE.CLEAN_THE_REFRIGERATOR';

    private ObjectManager $manager;

    public function getDependencies(): array
    {
        return [
            CleaningSubscriptionFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createLeviySchedule();

        $this->manager->flush();
    }

    private function createLeviySchedule(): void
    {
        $this->createLeviyVacuumingSchedule();
        $this->createLeviyWindowCleaningSchedule();
        $this->createLeviyCleanTheRefrigeratorSchedule();
    }


    private function createLeviyVacuumingSchedule(): void
    {
        /** @var CleaningSubscription $cleaningSubscription */
        $cleaningSubscription = $this->getReference(CleaningSubscriptionFixtures::VACUUMING);

        $fixture = new WeeklyCleaningSchedule(
            $cleaningSubscription,
            false,
            true,
            false,
            true,
            false,
            false,
            false
        );

        $this->manager->persist($fixture);
        $this->addReference(self::VACUUMING, $fixture);
    }

    private function createLeviyWindowCleaningSchedule(): void
    {
        /** @var CleaningSubscription $cleaningSubscription */
        $cleaningSubscription = $this->getReference(CleaningSubscriptionFixtures::WINDOW_CLEANING);

        $fixture = new MonthlyCleaningSchedule($cleaningSubscription, MonthlySchedule::lastWorkingDayOfTheMonth());

        $this->manager->persist($fixture);
        $this->addReference(self::WINDOW_CLEANING, $fixture);
    }

    private function createLeviyCleanTheRefrigeratorSchedule(): void
    {
        /** @var CleaningSubscription $cleaningSubscription */
        $cleaningSubscription = $this->getReference(CleaningSubscriptionFixtures::CLEAN_THE_REFRIGERATOR);

        /** @var CleaningSchedule $cleaningSchedule */
        $cleaningSchedule = $this->getReference(self::VACUUMING);

        $fixture = new MonthlyCleaningSchedule($cleaningSubscription, MonthlySchedule::firstDayOfTheMonth());
        $fixture->setParentSchedule($cleaningSchedule);

        $this->manager->persist($fixture);
        $this->addReference(self::CLEAN_THE_REFRIGERATOR, $fixture);
    }
}
