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
        $roles = $this->get('facebook')->getRoles();
        $userNode = $this->get('facebook')->getUserNode();
        $em = $this->getDoctrine()->getManager();
        $quizzes = $em->getRepository('AppBundle:Quizz')->findAll();
        $actualQuizz = null;
        $nextQuizzes = [];
        $previousQuizzes = [];
        $dateNow = new \DateTime('2015-07-01');

        foreach ($roles as $role) {
            foreach ($userNode as $user) {
                if ($user== $role['user']) {
                    if ($role['role'] == "administrators") {
                        $hiddenParams = 0;
                    } else {
                        $hiddenParams = 1;
                    }
                }
            }
        }

        foreach ($quizzes as $quizz) {
            if ($quizz->getDateStart()->format('m') == $dateNow->format('m')) {
                $actualQuizz = $quizz;
            } else if ($quizz->getDateEnd()->format('m') < $dateNow->format('m')) {
                array_push($previousQuizzes, $quizz);
            } else {
                array_push($nextQuizzes, $quizz);
            }
        }

        return $this->render('Front/Default/index.html.twig', [
            'username' => $userNode['name'],
            'actualQuizz' => $actualQuizz,
            'previousQuizzes' => $previousQuizzes,
            'nextQuizzes' => $nextQuizzes,
            'hiddenParams' => $hiddenParams
        ]);
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
