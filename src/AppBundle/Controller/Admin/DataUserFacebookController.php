<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\DataUserFacebook;
use AppBundle\Form\DataUserFacebookType;

/**
 * @Route("/datauserfacebook")
 */
class DataUserFacebookController extends Controller
{
    /**
     * @Route("/", name="admin_datauserfacebook_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:DataUserFacebook')->findAll();

        return $this->render('Admin/DataUserFacebook/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/delete/{token}/{id}", name="admin_datauserfacebook_delete")
     * @Method("GET")
     */
    public function deleteAction(DataUserFacebook $entity, $token)
    {
        if ($this->isCsrfTokenValid('delete_datauserfacebook', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->addFlash('success', "Le DataUserFacebook à été supprimé!");
        } else {
            $this->addFlash('error', 'Erreur survenu lors de la validation du token csrf, veuillez rééssayer.');
        }

        return $this->redirect($this->generateUrl('admin_datauserfacebook_index'));
    }
}
