<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ConfigurationType;

/**
 * @Route("/configuration")
 */
class ConfigurationController extends Controller
{
    /**
     * @route("/", name="admin_configuration_index")
     */
    public function indexAction(Request $request)
    {
        $configuration = $this->get('app.config')->getCurrent();

        $form = $this->createForm(new ConfigurationType(), $configuration);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->addFlash('success', "La configuration du site à été mis à jour!");
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Admin/Configuration/index.html.twig', [
            'form'   => $form->createView(),
        ]);
    }
}
