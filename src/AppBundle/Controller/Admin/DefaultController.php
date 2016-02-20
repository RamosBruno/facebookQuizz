<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_default_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nbOfParticipants = $em->getRepository('AppBundle:QuizzParticipation')->countParticipation();
        $userFacebook = $em->getRepository('AppBundle:DataUserFacebook')->findAll();
        $questions = $em->getRepository('AppBundle:Question')->findAll();
        $quizzes = $em->getRepository('AppBundle:Quizz')->findAll();

        $countQuizzOver = 0;
        $dateNow = new \DateTime();
        foreach ($quizzes as $quizz) {
             if ($quizz->getDateEnd()->format('Ymd') < $dateNow->format('Ymd')) {
                 $countQuizzOver++;
            }
        }

        return $this->render('Admin/Default/index.html.twig', [
            'nbOfParticipants' => $nbOfParticipants,
            'userFacebook' => $userFacebook,
            'questions' => $questions,
            'quizz' => $quizzes,
            'countQuizzOver' => $countQuizzOver
        ]);
    }
}
