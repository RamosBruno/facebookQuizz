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

        return $this->render('Admin/Question/form.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_question_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Question $entity)
    {
        $form = $this->createForm(new QuestionType(), $entity, ['action' => $this->generateUrl('admin_question_edit', ['id' => $entity->getId()])]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->addFlash('success', "La question à été édité!");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_quizz_edit', ['id' => $entity->getQuizz()->getId()]));
        }

        return $this->render('Admin/Question/form.html.twig', [
            'entity'  => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{token}/{id}", name="admin_question_delete")
     * @Method("GET")
     */
    public function deleteAction(Question $entity, $token)
    {
        if ($this->isCsrfTokenValid('delete_question', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->addFlash('success', "La Question à été supprimé!");
        } else {
            $this->addFlash('error', 'Erreur survenu lors de la validation du token csrf, veuillez rééssayer.');
        }

        return $this->redirect($this->generateUrl('admin_quizz_edit', ['id' => $entity->getQuizz()->getId()]));
    }
}
