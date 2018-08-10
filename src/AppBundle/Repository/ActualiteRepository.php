<?php

namespace AppBundle\Repository;

/**
 * ActualiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActualiteRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste des trois dernieres actualites 
     */
    public function findLastActualite($limit, $offset)
    {
        return $this->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->where('a.statut = 1')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getQuery()->getResult()
        ;
    }
}
