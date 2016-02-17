<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use AppBundle\Entity\Quizz;

class LoadQuizzData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $rules = $manager->getRepository('AppBundle:Rule')->findAll();

        for ($i = 1; $i < 11; $i++) {
            $y = ($i <= 9) ? '0' . $i : $i;
            $dateStart = new \DateTime('2016-' . $y . '-01');
            $dateStart->setTime(0,0);
            $dateEnd = clone $dateStart;
            $dateEnd->setTime(0,0);
            $countdown = new \DateTime('00:00:10');
            $quizz = (new Quizz())
                ->setName($faker->sentence(4))
                ->setDescription($faker->text())
                ->setGains($faker->text())
                ->setNumberOfWinner($faker->numberBetween(0, 10))
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd->modify('last day of this month'))
                ->setActive($i == 2 ? 1 : 0)
                ->setRule($rules[array_rand($rules, 1)])
                ->setNbQuestion($faker->numberBetween(5, 15))
                ->setCountdown($countdown)
            ;

            $manager->persist($quizz);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
