<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Quizz;

class LoadQuizzData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i < 11; $i++) {
            $y = ($i <= 9) ? '0' . $i : $i;
            $dateStart = new \DateTime('2015-' . $y . '-01');
            $dateEnd = clone $dateStart;
            $quizz = (new Quizz())
                ->setName($faker->sentence(4))
                ->setDescription($faker->text())
                ->setGains($faker->text())
                ->setNumberOfWinner($faker->numberBetween(0, 10))
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd->modify('last day of this month'))
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
        return 1;
    }
}
