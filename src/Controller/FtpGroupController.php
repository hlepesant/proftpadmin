<?php

namespace App\Controller;

use App\Entity\FtpGroup;
use App\Form\FtpGroupType;
use App\Repository\FtpGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ftp/group")
 */
class FtpGroupController extends Controller
{
    /**
     * @Route("/", name="ftp_group_index", methods="GET")
     */
    public function index(FtpGroupRepository $ftpGroupRepository): Response
    {
        return $this->render('ftp_group/index.html.twig', ['ftp_groups' => $ftpGroupRepository->findAll()]);
    }

    /**
     * @Route("/new", name="ftp_group_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $gid = $this->getDoctrine()
            ->getRepository(Ftpgroup::class)
            ->getNextGroupId();

        $ftpGroup = new FtpGroup();
        $ftpGroup->setGid($gid);

        $form = $this->createForm(FtpGroupType::class, $ftpGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ftpGroup);
            $em->flush();

            return $this->redirectToRoute('ftp_group_index');
        }

        return $this->render('ftp_group/new.html.twig', [
            'ftp_group' => $ftpGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ftp_group_show", methods="GET")
     */
    public function show(FtpGroup $ftpGroup): Response
    {
        return $this->render('ftp_group/show.html.twig', ['ftp_group' => $ftpGroup]);
    }

    /**
     * @Route("/{id}/edit", name="ftp_group_edit", methods="GET|POST")
     */
    public function edit(Request $request, FtpGroup $ftpGroup): Response
    {
        $form = $this->createForm(FtpGroupType::class, $ftpGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            #return $this->redirectToRoute('ftp_group_edit', ['id' => $ftpGroup->getId()]);
            return $this->redirectToRoute('ftp_group_index');
        }

        return $this->render('ftp_group/edit.html.twig', [
            'ftp_group' => $ftpGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ftp_group_delete", methods="DELETE")
     */
    public function delete(Request $request, FtpGroup $ftpGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ftpGroup->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ftpGroup);
            $em->flush();
        }

        return $this->redirectToRoute('ftp_group_index');
    }

    /**
     * @Route("/", name="ftp_group_redirect")
    public function redirect(): RedirectResponse
    {
		return $this->redirectToRoute('ftp_group_index');
    }
     */
}
