<?php

declare(strict_types=1);

namespace App\NationalHoliday\Infrastructure\Repository;

use App\NationalHoliday\Domain\Model\NationalHoliday;
use App\NationalHoliday\Domain\Repository\NationalHolidayRepositoryInterface;
use App\NationalHoliday\Domain\ValueObject\NationalHolidayId;
use App\System\Domain\Repository\AbstractRepository;
use DatePeriod;
use Doctrine\Common\Collections\Collection;

/**
 * @method NationalHoliday find($id)
 * @method NationalHoliday[] findAll()
 * @method NationalHoliday[] findBy($criteria, $orderBy, $limit, $offset)
 * @method NationalHoliday findOneBy($criteria)
 */
class NationalHolidayRepository extends AbstractRepository implements NationalHolidayRepositoryInterface
{
    public function get(NationalHolidayId $id): NationalHoliday
    {
        return $this->find($id->getValue());
    }

    /**
     * @return NationalHoliday[]
     */
    public function getForDateRange(DatePeriod $datePeriod, string $country): Collection
    {
        return $this->entityManager->createQueryBuilder()
            ->select('national_holiday')
            ->from(NationalHoliday::class, 'national_holiday')
            ->andWhere('national_holiday.country = :country')
            ->andWhere('national_holiday.date <= :start AND national_holiday.date >= :end')
            ->setParameter('country', $country)
            ->setParameter('start', $datePeriod->start)
            ->setParameter('end', $datePeriod->end)
            ->getQuery()
            ->getResult();
    }

    public function persist(NationalHoliday $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    protected function getEntity(): string
    {
        return NationalHoliday::class;
    }
}
