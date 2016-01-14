<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Rule;
use AppBundle\Form\RuleType;

/**
 * @Route("/rule")
 */
class RuleController extends Controller
{
    /**
     * @Route("/", name="admin_rule_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Rule')->findAll();

        return $this->render('Admin/Rule/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="admin_rule_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entity = new Rule();
        $form = $this->createForm(new RuleType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash('success', "Le Rule à été créé!");

            return $this->redirectToRoute('admin_rule_index');
        }

        return $this->render('Admin/Rule/new.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_rule_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rule $entity)
    {
        $form = $this->createForm(new RuleType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->addFlash('success', "Le Rule à été édité!");
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Admin/Rule/edit.html.twig', [
            'entity'  => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{token}/{id}", name="admin_rule_delete")
     * @Method("GET")
     */
    public function deleteAction(Rule $entity, $token)
    {
        if ($this->isCsrfTokenValid('delete_rule', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->addFlash('success', "Le Rule à été supprimé!");
        } else {
            $this->addFlash('error', 'Erreur survenu lors de la validation du token csrf, veuillez rééssayer.');
        }

        return $this->redirect($this->generateUrl('admin_rule_index'));
    }
}
