<?php
namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class QuizzRepository extends EntityRepository
{
    public function getParticipant()
    {
        $qb =  $this->createQueryBuilder('q')
            ->select('DISTINCT(d)')
            ->leftJoin('q.quizzParticipation', 'p')
            ->leftJoin('p.dataUserFacebook', 'd')
        ;

        return $qb->getQuery()->getResult();
    }
}