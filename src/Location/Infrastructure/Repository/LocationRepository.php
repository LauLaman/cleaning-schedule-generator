<?php

declare(strict_types=1);

namespace App\Location\Infrastructure\Repository;

use App\Location\Domain\Model\Location;
use App\Location\Domain\Repository\LocationRepositoryInterface;
use App\Location\Domain\ValueObject\LocationId;
use App\System\Domain\Repository\AbstractRepository;

/**
 * @method Location find($id)
 * @method Location[] findAll()
 * @method Location[] findBy($criteria, $orderBy, $limit, $offset)
 * @method Location findOneBy($criteria)
 */
class LocationRepository extends AbstractRepository implements LocationRepositoryInterface
{
    public function get(LocationId $id): Location
    {
        return $this->find($id->getValue());
    }

    public function persist(Location $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    protected function getEntity(): string
    {
        return Location::class;
    }
}
