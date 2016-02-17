<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\LikeFacebook;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\DataUserFacebook;
use Faker\Factory;


class LoadDataUserFacebookData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 1; $i < 11; $i++) {
            $facebookUser = (new DataUserFacebook())
                ->setId($faker->randomNumber($nbDigits = 8))
                ->setProfilName($faker->name)
                ->setEmail($faker->email)
                ->setPictureProfilUrl($faker->imageUrl($width = 640, $height = 480))
                ->addLike((new LikeFacebook())->setName($faker->sentence(4)))
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