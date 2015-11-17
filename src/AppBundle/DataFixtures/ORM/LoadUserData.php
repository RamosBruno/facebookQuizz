<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = (new User())
            ->setUsername('amorin')
            ->setPlainPassword('mypass')
            ->setEmail('amorin@suchweb.fr')
            ->setFirstname('Adrien')
            ->setLastname('Morin')
            ->setEnabled(1)
            ->addRole('ROLE_ADMIN');
        $manager->persist($userAdmin);

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
