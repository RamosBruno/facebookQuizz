<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ContentBlock;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction()
    {
        $userNode = $this->get('facebook')->getUserNode();

        return $this->render('Front/Default/index.html.twig', [
            'username' => $userNode['name']
        ]);
    }
}
