<?php

namespace AppBundle\Repository;

/**
 * CitationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CitationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste decroissante des citatins
     */
    public function findCitationDESC()
    {
        return $this->createQueryBuilder('c')
                    ->orderBy('c.id', 'DESC')
                    ->getQuery()->getResult()
        ;
    }
}
