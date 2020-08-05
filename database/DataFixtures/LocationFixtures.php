<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Location\Domain\Model\Location;
use App\System\Domain\Model\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public const LEVIY = 'location.leviy';
    public const LAURENS = 'location.laurens';

    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createLeviyLocation();
        $this->createLaurensLocation();

        $this->manager->flush();
    }

    private function createLeviyLocation(): void
    {
        $fixture = new Location(
            'Leviy B.V.',
            new Address(
                'Databankweg',
                12,
                '3821 AL',
                'Amersfoort',
                'NLD',
                'H',
            )
        );

        $this->manager->persist($fixture);
        $this->addReference(self::LEVIY, $fixture);
    }

    private function createLaurensLocation(): void
    {
        $fixture = new Location(
            'Laurens Laman',
            new Address(
                'Italiëstraat',
                34,
                '1363 CE',
                'Almere',
                'NLD'
            )
        );

        $this->manager->persist($fixture);
        $this->addReference(self::LAURENS, $fixture);
    }
}
