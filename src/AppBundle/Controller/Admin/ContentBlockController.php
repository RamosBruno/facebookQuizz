<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ContentBlock;
use AppBundle\Form\ContentBlockType;

/**
 * @Route("/content-block")
 */
class ContentBlockController extends Controller
{

    /**
 * @Route("/", name="admin_contentblock_index")
 */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:ContentBlock')->findAll();

        return $this->render('Admin/ContentBlock/index.html.twig', [
            'contentBlocks' => $entities,
        ]);
    }

    /**
     * @route("/{id}/edit", name="admin_contentblock_edit")
     */
    public function editAction(Request $request, ContentBlock $contentBlock)
    {
        $form = $this->createForm(new ContentBlockType(), $contentBlock);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->addFlash('success', "Le content block {$contentBlock->getSlug()} à été édité!");
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Admin/ContentBlock/edit.html.twig', [
            'contentBlock' => $contentBlock,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @route("/new", name="admin_contentblock_new")
     */
    public function newAction(Request $request)
    {
        $contentBlock = new ContentBlock();
        $form = $this->createForm(new ContentBlockType(), $contentBlock);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contentBlock);
            $em->flush();
            $this->addFlash('sucess', "Le content block {$contentBlock->getSlug()} à été créé!");

            return $this->redirectToRoute('admin_contentblock_index');
        }

        return $this->render('Admin/ContentBlock/new.html.twig', [
            'contentBlock' => $contentBlock,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @route("/remove/{token}/{id}", name="admin_contentblock_remove")
     */
    public function removeAction(ContentBlock $contentBlock, $token)
    {
        if ($this->isCsrfTokenValid('remove_contentblock', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contentBlock);
            $em->flush();
            $this->addFlash('success', "Le content block {$contentBlock->getSlug()} à été supprimé!");
        } else {
            $this->addFlash('error', 'Erreur survenu lors de la validation du token csrf, veuillez rééssayer.');
        }

        return $this->redirectToRoute('admin_contentblock_index');
    }
}
