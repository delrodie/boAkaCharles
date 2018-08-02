<?php

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findListASC(){
        return $this->createQueryBuilder('u')
                    ->where('u.username <> :username')
                    ->orderBy('u.username', 'ASC')
                    ->setParameter('username', 'delrodie')
                    ->getQuery()->getResult()
        ;
    }
}