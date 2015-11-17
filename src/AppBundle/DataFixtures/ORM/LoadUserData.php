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

        $userAdmin = (new User())
            ->setUsername('bruno')
            ->setPlainPassword('root')
            ->setEmail('bruno_ramos@ymail.com')
            ->setFirstname('Bruno')
            ->setLastname('Ramos')
            ->setEnabled(1)
            ->addRole('ROLE_ADMIN');
        $manager->persist($userAdmin);

        $userAdmin = (new User())
            ->setUsername('thomas')
            ->setPlainPassword('root')
            ->setEmail('tomdrouv1@gmail.com')
            ->setFirstname('Thomas')
            ->setLastname('Drouvin')
            ->setEnabled(1)
            ->addRole('ROLE_ADMIN');
        $manager->persist($userAdmin);

        $userAdmin = (new User())
            ->setUsername('benjamin')
            ->setPlainPassword('root')
            ->setEmail('benjamin.romanelli@neuf.fr')
            ->setFirstname('Benjamin')
            ->setLastname('Romanelli')
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
