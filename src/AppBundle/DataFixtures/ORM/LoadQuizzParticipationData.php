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
        foreach($quizz as $quiz)
        {
            foreach($quiz->getQuestions() as $question)
            {
                foreach($usersFacebook as $userFacebook)
                {
                    for($i=1; $i< 11; $i++)
                    {
                        $quizzParticipation = (new QuizzParticipation())
                            ->setDate(new \DateTime('now'))
                            ->setDataUserFacebook($userFacebook)
                            ->setQuestion($question)
                            ->setValid($faker->boolean(50))
                        ;
                        $manager->persist($quizzParticipation);
                    }
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