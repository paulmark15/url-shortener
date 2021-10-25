<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class BaseManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * BaseService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $this->setRepository();
    }

    /**
     * get all entities.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * get one by id.
     *
     * @param string $id
     *
     * @return object|null
     */
    public function getOneById(string $id): ?object
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * flush data to db.
     */
    public function flush(): void
    {
        $this->em->flush();
    }

    /**
     * detaches all object from doctrine.
     */
    public function clear(): void
    {
        $this->em->clear();
    }

    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update($entity, bool $flush = true)
    {
        try {
            $this->em->persist($entity);

            if ($flush) {
                $this->flush();
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $entity;
    }

    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create($entity, $flush = true)
    {
        try {
            $this->em->persist($entity);

            if ($flush) {
                $this->flush();
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $entity;
    }

    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function remove($entity, $flush = true)
    {
        try {
            $this->em->remove($entity);

            if ($flush) {
                $this->flush();
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $entity;
    }

    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;

    /**
     * set repository.
     */
    private function setRepository(): void
    {
        $this->repository = $this->em->getRepository($this->getEntityClass());
    }
}
