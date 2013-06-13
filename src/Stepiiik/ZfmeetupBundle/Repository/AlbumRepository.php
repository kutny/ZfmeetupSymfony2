<?php

namespace Stepiiik\ZfmeetupBundle\Repository;

use Doctrine\ORM\EntityManager;
use Stepiiik\ZfmeetupBundle\Entity\Album;

class AlbumRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     * @return Album
     */
    public function find($id) {
        $query = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(Album::ENTITY_NAME, 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @return Album[]
     */
    public function findAll() {
        $query = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(Album::ENTITY_NAME, 'p')
            ->getQuery();

        return $query->getResult();
    }

    public function save(Album $album) {
        $this->entityManager->persist($album);
        $this->entityManager->flush();
    }

    public function remove(Album $album) {
        $this->entityManager->remove($album);
        $this->entityManager->flush();
    }

}
