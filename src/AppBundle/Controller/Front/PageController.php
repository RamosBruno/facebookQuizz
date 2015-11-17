<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ContentBlock;

class PageController extends Controller
{
    /**
     * @Route("/legal_notice", name="front_page_legal_notice")
     */
    public function legalNoticeAction()
    {
        return $this->render('Front/Page/legal_notice.html.twig');
    }

    /**
     * @Route("/contact", name="front_page_contact")
     */
    public function contactAction()
    {
        return $this->render('Front/Page/contact.html.twig');
    }
}
