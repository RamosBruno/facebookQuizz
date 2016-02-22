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
        $em = $this->getDoctrine()->getManager();
        $quizzes = $em->getRepository('AppBundle:Quizz')->findAll();
        $actualQuizz = null;
        $nextQuizzes = [];
        $previousQuizzes = [];
        $dateNow = new \DateTime();

        $session = $this->get('session');
        if (empty($session->get('user'))) {
            $userNode = $this->get('facebook')->getUserNode();
            $session->set('user', $userNode);
        }

        foreach ($quizzes as $quizz) {
            if ($quizz->getActive() && $quizz->getDateStart()->format('Ymd') <= $dateNow->format('Ymd') && $quizz->getDateEnd()->format('Ymd') > $dateNow->format('Ymd')) {
                $actualQuizz = $quizz;
            } else if ($quizz->getDateEnd()->format('Ymd') <= $dateNow->format('Ymd')) {
                array_push($previousQuizzes, $quizz);
            } else {
                array_push($nextQuizzes, $quizz);
            }
        }

        return $this->render('Front/Default/index.html.twig', [
            'username' => $session->get('user')['name'],
            'actualQuizz' => $actualQuizz,
            'previousQuizzes' => $previousQuizzes,
            'nextQuizzes' => $nextQuizzes
        ]);
    }

    /**
     * @Route("/contentBlock/{slug}", name="front_get_content_block")
     * @param $slug
     * @return $this
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
