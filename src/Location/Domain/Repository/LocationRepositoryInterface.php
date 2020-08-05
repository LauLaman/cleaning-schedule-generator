<?php

declare(strict_types=1);

namespace App\Location\Domain\Repository;

use App\Location\Domain\Model\Location;
use App\Location\Domain\ValueObject\LocationId;
use App\System\Domain\Repository\Exception\NoResultException;

interface LocationRepositoryInterface
{
    /**
     * @throws NoResultException
     */
    public function get(LocationId $id): Location;

    public function persist(Location $entity): void;

    public function flush(): void;
}
