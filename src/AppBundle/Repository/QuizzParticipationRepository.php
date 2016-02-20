<?php
namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class QuizzParticipationRepository extends EntityRepository
{
    public function countParticipation()
    {
        return $this->createQueryBuilder('qp')
            ->select('COUNT(qp)')
            ->getQuery()
            ->getResult()[0][1];
    }

    public function getAnswerByUser($id_user, $id_question, $id_quizz){
        $qb = $this->createQueryBuilder('qp')
            ->where('qp.quizz = :quizz')
            ->andWhere('qp.question = :question')
            ->andWhere('qp.dataUserFacebook = :dataUserFacebook')
            ->setParameter('dataUserFacebook', $id_user)
            ->setParameter('quizz', $id_quizz)
            ->setParameter('question', $id_question)
            ->getQuery();

        $quizz_participation = $qb->getResult();

        if(empty($quizz_participation)){
            return true;
        }
        else{
            return false;
        }
    }

    public function getParticipationByUser($id_user, $id_quizz)
    {
        $qp = $this->createQueryBuilder('qp')
            ->where('qp.quizz = :quizz')
            ->andWhere('qp.dataUserFacebook = :dataUserFacebook')
            ->setParameter('quizz', $id_quizz)
            ->setParameter('dataUserFacebook', $id_user)
            ->getQuery();

        $quizz_participation = $qp->getResult();

        if(!empty($quizz_participation)) {
            return true;
        } else {
            return false;
        }
    }
}