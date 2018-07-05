<?php

namespace App\Controller;

use App\Entity\Ftpgroup;
use App\Entity\Ftpuser;

use App\Form\FtpuserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

# @ParamConverter("ftpgroup", class="Ftpgroup:class",  options={"id" = "id_group"})

/**
 * Ftpuser controller.
 *
 * @Route("ftpuser")
 * @Security("has_role('ROLE_ADMIN')")
 */
class FtpuserController extends Controller
{
    /**
     * Lists all ftpuser entities.
     *
     * @Route("/{id_group}", name="ftpuser_index")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method("GET")
     */
    public function indexAction(Ftpgroup $ftpgroup)
    {
        $em = $this->getDoctrine()->getManager();

        $ftpgroup = $em->getRepository(Ftpgroup::class)->find($ftpgroup);

        if (!$ftpgroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpgroup->getId()
            );
        }

        #$ftpusers = $em->getRepository(Ftpuser::class)->findUsersForGroup($ftpgroup->getId());
		$ftpusers = $em->getRepository(Ftpuser::class)->findBy([
			"group" => $ftpgroup->getId(),
		]);

        return $this->render('ftpuser/index.html.twig', array(
            'ftpgroup' => $ftpgroup,
            'ftpusers' => $ftpusers,
        ));
    }

    /**
     * Creates a new ftpuser entity.
     *
     * @Route("/{id_group}/new", name="ftpuser_new")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Ftpgroup $ftpgroup)
    {
        $em = $this->getDoctrine()->getManager();
        $ftpgroup = $em->getRepository(Ftpgroup::class)->find($ftpgroup);
        if (!$ftpgroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpgroup->getId()
            );
        }

        $uid = $this->getDoctrine()
            ->getRepository(Ftpuser::class)
            ->getNextUserId();

        $ftpuser = new Ftpuser();
        $ftpuser->setShell('/bin/sh');
        $ftpuser->setHome(sprintf('/opt/FtpSites/%s', $ftpgroup->getGroupname()));
        $ftpuser->setUid($uid);
        $ftpuser->setGroup($ftpgroup);

        $form = $this->createForm(FtpuserType::class, $ftpuser, array(
            'action' => $this->generateUrl('ftpuser_new', array('id_group' => $ftpgroup->getId())),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ftpuser);
            $em->flush();

            return $this->redirectToRoute('ftpuser_index', array('id_group' => $ftpgroup->getId()));
        }

        return $this->render('ftpuser/new.html.twig', array(
            'ftpgroup' => $ftpgroup,
            'ftpuser' => $ftpuser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ftpuser entity.
     *
     * @Route("/{id_group}/{id}", name="ftpuser_show")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method("GET")
     */
	/*
    public function showAction(Ftpuser $ftpuser)
    {
        $deleteForm = $this->createDeleteForm($ftpuser);

        return $this->render('ftpuser/show.html.twig', array(
            'ftpuser' => $ftpuser,
            'delete_form' => $deleteForm->createView(),
        ));
    }
	 */

    /**
     * Displays a form to edit an existing ftpuser entity.
     *
     * @Route("/{id_group}/{id}/edit", name="ftpuser_edit")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ftpgroup $ftpgroup, Ftpuser $ftpuser)
    {
        $em = $this->getDoctrine()->getManager();
        $ftpgroup = $em->getRepository(Ftpgroup::class)->find($ftpgroup);
        if (!$ftpgroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpgroup->getId()
            );
        }

        $editForm = $this->createForm(FtpuserType::class, $ftpuser);

		$editForm->remove('uid');
		$editForm->remove('home');
		$editForm->remove('shell');
		$editForm->remove('password');

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            #$this->getDoctrine()->getManager()->flush();
            $em->flush();

            return $this->redirectToRoute('ftpuser_index', array('id_group' => $ftpgroup->getId()));
        }

        return $this->render('ftpuser/edit.html.twig', array(
            'ftpuser' => $ftpuser,
            'ftpgroup' => $ftpgroup,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Displays a form to update the password of an existing ftpuser entity.
     *
     * @Route("/{id_group}/{id}/password", name="ftpuser_password")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method({"GET", "POST"})
     */
    public function passwordAction(Request $request, Ftpgroup $ftpgroup, Ftpuser $ftpuser)
    {
        $em = $this->getDoctrine()->getManager();
        $ftpgroup = $em->getRepository(Ftpgroup::class)->find($ftpgroup);
        if (!$ftpgroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpgroup->getId()
            );
        }

        $passwordForm = $this->createForm(FtpuserType::class, $ftpuser);

		$passwordForm->remove('firstname');
		$passwordForm->remove('lastname');
		$passwordForm->remove('uid');
		$passwordForm->remove('home');
		$passwordForm->remove('shell');

        $passwordForm->handleRequest($request);

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            #$this->getDoctrine()->getManager()->flush();
            $em->flush();

            return $this->redirectToRoute('ftpuser_index', array('id_group' => $ftpgroup->getId()));
        }

        return $this->render('ftpuser/password.html.twig', array(
            'ftpuser' => $ftpuser,
            'ftpgroup' => $ftpgroup,
            'password_form' => $passwordForm->createView(),
        ));
    }

    /**
     * Deletes a ftpuser entity.
     *
     * @Route("/{id_group}/{id}", name="ftpuser_delete")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ftpgroup $ftpgroup, Ftpuser $ftpuser)
    {
        $form = $this->createDeleteForm($ftpgroup, $ftpuser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ftpuser);
            $em->flush();
        }

        return $this->redirectToRoute('ftpuser_index', array('id_group' => $ftpgroup->getId()));
    }

    /**
     * Creates a form to delete a ftpuser entity.
     *
     * @param Ftpuser $ftpuser The ftpuser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ftpgroup $ftpgroup, Ftpuser $ftpuser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ftpuser_delete', array('id_group' => $ftpgroup->getId(), 'id' => $ftpuser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Delete Form Generator.
     *
     * @Route("/delete_form/{id_group}/{id}", name="ftpuser_delete_form")
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     * @Method("POST")
     */
    public function delete_form(Ftpgroup $ftpgroup, Ftpuser $ftpuser)
    {
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('ftpuser_delete', array('id_group' => $ftpgroup->getId(), 'id' => $ftpuser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;

        return $this->render('ftpuser/delete_form.html.twig', array(
            'delete_form' => $deleteForm->createView(),
        ));
    }
}