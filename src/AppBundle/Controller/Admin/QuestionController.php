<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;

/**
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * @Route("/new", name="admin_question_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entity = new Question();
        $form = $this->createForm(new QuestionType(), $entity, ['action' => $request->getUri()]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $quizz = $em->getRepository('AppBundle:Quizz')->find($request->get('quizzId'));
            if ($quizz) {
                $entity->setQuizz($quizz);
                $em->persist($entity);
                $em->flush();

                $this->addFlash('success', "La question à été créé!");
            } else {
                $this->addFlash('error', "Le quizz demandé n'existe pas!");
            }

            return $this->redirectToRoute('admin_quizz_edit', ['id' => $entity->getQuizz()->getId()]);
        }

        return $this->render('Admin/question/new.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }
}
