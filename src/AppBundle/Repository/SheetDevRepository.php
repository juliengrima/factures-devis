<?php

namespace AppBundle\Repository;

/**
 * SheetDevRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SheetDevRepository extends \Doctrine\ORM\EntityRepository
{
    public function countByDev()
    {
        $qb = $this->createQueryBuilder('e');
        $qb ->select($qb->expr()->count('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function hightId(){
        $qb = $this->createQueryBuilder('e');
        $qb ->select($qb->expr()->max('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
