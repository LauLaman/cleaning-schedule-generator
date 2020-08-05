<?php

declare(strict_types=1);

namespace App\System\Domain\Repository;

use App\System\Domain\Repository\Exception\NoResultException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractRepository implements ObjectRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->getEntity());
    }

    abstract protected function getEntity(): string;

    /**
     * @throws NoResultException
     */
    public function find($id)
    {
        $entity = $this->repository->find($id);
        $this->throwExceptionOnNull($entity);

        return $entity;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @throws NoResultException
     */
    public function findOneBy(array $criteria)
    {
        $entity = $this->repository->findOneBy($criteria);
        $this->throwExceptionOnNull($entity);

        return $entity;
    }

    public function getClassName()
    {
        return $this->getEntity();
    }

    /**
     * @throws NoResultException
     */
    protected function throwExceptionOnNull($entity = null): void
    {
        if (!$entity) {
            throw new NoResultException();
        }
    }
}
