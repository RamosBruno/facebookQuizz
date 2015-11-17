<?php

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Configuration
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function getCurrent()
    {
        $configuration = $this->om->getRepository('AppBundle:Configuration')->findOneBy([], ['id' => 'DESC']);
        if (!$configuration) {
            throw new HttpException(
                500,
                'Unable to find Configuration entry in database, please verify that the application is installed correctly.'
            );
        }

        return $configuration;
    }
}
