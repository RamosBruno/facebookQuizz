<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Question;

class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        $quizzes = $manager->getRepository('AppBundle:Quizz')->findAll();
        foreach ($quizzes as $quizz) {
            for ($i = 0; $i < $faker->numberBetween(5, 20); $i++) {
                $question = (new Question())
                    ->setQuestion($faker->sentence(15))
                    ->setResponse1($faker->sentence(8))
                    ->setResponse2($faker->sentence(8))
                    ->setResponse3($faker->sentence(8))
                    ->setResponse4($faker->sentence(8))
                    ->setResponseValide($faker->numberBetween(1, 4))
                    ->setQuizz($quizz)
                ;
                $manager->persist($question);
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
