<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\QuizzParticipation;


class LoadQuizzParticipationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $usersFacebook = $manager->getRepository('AppBundle:DataUserFacebook')->findAll();
        $quizz = $manager->getRepository('AppBundle:Quizz')->findAll();
        foreach ($quizz as $quiz) {
            foreach ($quiz->getQuestions() as $question) {
                foreach ($usersFacebook as $userFacebook) {
                    $quizzParticipation = (new QuizzParticipation())
                        ->setDate(new \DateTime('now'))
                        ->setDataUserFacebook($userFacebook)
                        ->setQuizz($quiz)
                        ->setQuestion($question)
                        ->setValid($faker->boolean(50))
                        ->setCountdown(new \DateTime("00:00:00"))
                    ;
                    $manager->persist($quizzParticipation);
                }
            }
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}