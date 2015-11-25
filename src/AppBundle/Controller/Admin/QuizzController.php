<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Quizz;
use AppBundle\Form\QuizzType;

/**
 * @Route("/quizz")
 */
class QuizzController extends Controller
{
    /**
     * @Route("/", name="admin_quizz_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Quizz')->findAll();

        return $this->render('Admin/Quizz/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="admin_quizz_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entity = new Quizz();
        $form = $this->createForm(new QuizzType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash('success', "Le Quizz à été créé!");

            return $this->redirectToRoute('admin_quizz_index');
        }

        return $this->render('Admin/Quizz/new.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_quizz_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Quizz $entity)
    {
        $form = $this->createForm(new QuizzType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->addFlash('success', "Le Quizz à été édité!");
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Admin/Quizz/edit.html.twig', [
            'entity'  => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{token}/{id}", name="admin_quizz_delete")
     * @Method("GET")
     */
    public function deleteAction(Quizz $entity, $token)
    {
        if ($this->isCsrfTokenValid('delete_quizz', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->addFlash('success', "Le Quizz à été supprimé!");
        } else {
            $this->addFlash('error', 'Erreur survenu lors de la validation du token csrf, veuillez rééssayer.');
        }

        return $this->redirect($this->generateUrl('admin_quizz_index'));
    }
}
