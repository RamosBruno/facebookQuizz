<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\DataUserFacebook;


class LoadDataUserFacebookData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i < 11; $i++) {
            $facebookUser = (new DataUserFacebook())
                ->setId($faker->randomNumber($nbDigits = 8))
                ->setProfilName($faker->name)
                ->setEmail($faker->email)
                ->setPictureProfilUrl($faker->imageUrl($width = 640, $height = 480))
            ;
            $manager->persist($facebookUser);
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