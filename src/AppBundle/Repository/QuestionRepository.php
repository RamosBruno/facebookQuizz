<?php
namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    public function getIdQuestion($question_id, $quizz_id)
    {
        $qb = $this->createQueryBuilder('q')
            ->where('q.quizz = :quizz_id')
            ->andWhere('q.id != :question_id')
            ->setParameter('question_id', $question_id)
            ->setParameter('quizz_id', $quizz_id)
            ->getQuery();

        $questions = $qb->getResult();

        $tab_id = [];
        foreach($questions as $q){
            array_push($tab_id, $q->getId());
        }

        return $tab_id;
    }
}