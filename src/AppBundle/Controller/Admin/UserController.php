<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="admin_user_index")
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();

        return $this->render('Admin/User/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new")
     */
    public function createAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $form = $this->createForm(new UserType(), $user, [
            'newUser' => true,
            'validation_groups' => ['Registration']
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);
            $this->addFlash('sucess', "L'utilisateur {$user->getFullName()} à été créé!");

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('Admin/User/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_user_edit")
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->addFlash('success', "L'utilisateur {$user->getFullName()} à été édité!");
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Admin/User/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{token}/{id}", name="admin_user_remove")
     */
    public function removeAction(User $user, $token)
    {
        if ($this->isCsrfTokenValid('remove_user', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', "L'utilisateur {$user->getFullName()} à été supprimé!");
        } else {
            $this->addFlash('error', 'Erreur survenu lors de la validation du token csrf, veuillez rééssayer.');
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
