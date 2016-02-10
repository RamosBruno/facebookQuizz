<?php
namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class QuizzParticipationRepository extends EntityRepository
{
    public function countParticipationByQuizz()
    {

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
}