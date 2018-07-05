<?php

namespace App\Controller;

use App\Entity\Ftpgroup;
use App\Entity\Ftpuser;

use App\Form\FtpgroupType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ftpgroup controller.
 *
 * @Route("ftpgroup")
 * @Security("has_role('ROLE_ADMIN')")
 */
class FtpgroupController extends Controller
{
    /**
     * Lists all ftpgroup entities.
     *
     * @Route("/", name="ftpgroup_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        #$em = $this->getDoctrine()->getManager();
        #$ftpgroups = $em->getRepository(Ftpgroup::class)->findAll();

		$repository = $this->getDoctrine()->getRepository(Ftpgroup::class);
		$ftpgroups = $repository->findAll();


        return $this->render('ftpgroup/index.html.twig', array(
            'ftpgroups' => $ftpgroups,
        ));
    }

    /**
     * Creates a new ftpgroup entity.
     *
     * @Route("/new", name="ftpgroup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $gid = $this->getDoctrine()
            ->getRepository(Ftpgroup::class)
            ->getNextGroupId();

        $ftpgroup = new Ftpgroup();
        $ftpgroup->setGid($gid);

        $form = $this->createForm(FtpgroupType::class, $ftpgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ftpgroup);
            $em->flush();

            #return $this->redirectToRoute('ftpgroup_show', array('id' => $ftpgroup->getId()));
            return $this->redirectToRoute('ftpgroup_index');
        }

        return $this->render('ftpgroup/new.html.twig', array(
            'ftpgroup' => $ftpgroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ftpgroup entity.
     *
     * @Route("/{id}", name="ftpgroup_show")
     * @Method("GET")
     */
    public function showAction(Ftpgroup $ftpgroup)
    {
        $deleteForm = $this->createDeleteForm($ftpgroup);

        return $this->render('@Proftp/ftpgroup/show.html.twig', array(
            'ftpgroup' => $ftpgroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ftpgroup entity.
     *
     * @Route("/{id}/edit", name="ftpgroup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ftpgroup $ftpgroup)
    {
        #$editForm = $this->createForm('ProftpBundle\Form\FtpgroupType', $ftpgroup);
        $editForm = $this->createForm(FtpgroupType::class, $ftpgroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            #return $this->redirectToRoute('ftpgroup_edit', array('id' => $ftpgroup->getId()));
            return $this->redirectToRoute('ftpgroup_index');
        }

        return $this->render('ftpgroup/edit.html.twig', array(
            'ftpgroup' => $ftpgroup,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a ftpgroup entity.
     *
     * @Route("/{id}", name="ftpgroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ftpgroup $ftpgroup)
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $form = $this->createDeleteForm($ftpgroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ftpgroup);
            $em->flush();
        }

        return $this->redirectToRoute('ftpgroup_index');
    }

    /**
     * Creates a form to delete a ftpgroup entity.
     *
     * @param Ftpgroup $ftpgroup The ftpgroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ftpgroup $ftpgroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ftpgroup_delete', array('id' => $ftpgroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Delete Form Generator.
     *
     * @Route("/delete_form/{id}", name="ftpgroup_delete_form")
     * @Method("POST")
     */
    public function delete_form(int $id)
    {
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('ftpgroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;

        return $this->render('ftpgroup/delete_form.html.twig', array(
            'id' => $id,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
