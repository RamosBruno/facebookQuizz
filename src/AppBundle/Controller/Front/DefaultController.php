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
        return $this->render('Front/Default/index.html.twig');
    }

    /**
     * @Route("/contentBlock/{slug}", name="front_get_content_block")
     */
    public function getContentBlockAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $contentBlock = $em->getRepository('AppBundle:ContentBlock')->findOneBySlug($slug);

        if (!$contentBlock) {
            $contentBlock = new ContentBlock();
            $contentBlock->setSlug($slug);
            $em->persist($contentBlock);
            $em->flush();
        }

        return $this->render('Front/Default/_content_block.html.twig', [
            'contentBlock' => $contentBlock
        ]);
    }
}
