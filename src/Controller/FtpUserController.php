<?php

namespace App\Controller;

use App\Entity\FtpUser;
use App\Entity\FtpGroup;

use App\Form\FtpUserType;
use App\Repository\FtpUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/ftp/user")
 */
class FtpUserController extends Controller
{
    /**
     * @Route("/{id_group}", name="ftp_user_index", methods="GET")
     * @ParamConverter("ftpGroup", options={"id" = "id_group"})
     */
    public function index(FtpUserRepository $ftpUserRepository, Ftpgroup $ftpGroup): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ftpGroup = $em->getRepository(FtpGroup::class)->find($ftpGroup);

        if (!$ftpGroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpGroup->getId()
            );
        }

		return $this->render('ftp_user/index.html.twig', [
			'ftp_group' => $ftpGroup,
			'ftp_users' => $ftpUserRepository->findByGroupId($ftpGroup->getId())
		]);

    }

    /**
     * @Route("/new/{id_group}", name="ftp_user_new", methods="GET|POST")
     * @ParamConverter("ftpGroup", options={"id" = "id_group"})
     */
    public function new(Request $request, Ftpgroup $ftpGroup): Response
    {
        $uid = $this->getDoctrine()
            ->getRepository(FtpUser::class)
            ->getNextUserId();

        $ftpUser = new FtpUser();
        $ftpUser->setUid($uid);
        $ftpUser->setShell('/bin/sh');
        $ftpUser->setFtpGroup($ftpGroup);
        $ftpUser->setLoginCount(0);

        $form = $this->createForm(FtpUserType::class, $ftpUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

			$ftpUser->setHome(sprintf('/opt/FtpSites/%s/%s', $ftpGroup->getGroupname(), $ftpUser->getUsername()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($ftpUser);
            $em->flush();

            return $this->redirectToRoute('ftp_user_index', ['id_group' => $ftpGroup->getId()]);
        }

        $em = $this->getDoctrine()->getManager();
        $ftpGroup = $em->getRepository(FtpGroup::class)->find($ftpGroup);

        return $this->render('ftp_user/new.html.twig', [
            'ftp_group' => $ftpGroup,
            'ftp_user' => $ftpUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ftp_user_show", methods="GET")
     */
    public function show(FtpUser $ftpUser): Response
    {
        return $this->render('ftp_user/show.html.twig', ['ftp_user' => $ftpUser]);
    }

    /**
     * @Route("/{id_group}/{id}/edit", name="ftp_user_edit", methods="GET|POST")
     * @ParamConverter("ftpGroup", options={"id" = "id_group"})
     */
    public function edit(Request $request, FtpUser $ftpUser, Ftpgroup $ftpGroup): Response
    {
        $form = $this->createForm(FtpUserType::class, $ftpUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('ftp_user_edit', [
				'id' => $ftpUser->getId(),
				'id_group' => $ftpGroup->getId(),
			]);
        }

        return $this->render('ftp_user/edit.html.twig', [
            'ftp_user' => $ftpUser,
            'ftp_group' => $ftpGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id_group}/{id}/password", name="ftp_user_password", methods="GET|POST")
     * @ParamConverter("ftpGroup", options={"id" = "id_group"})
     */
    public function password(Request $request, FtpUser $ftpUser, Ftpgroup $ftpGroup): Response
    {
        $form = $this->createForm(FtpUserType::class, $ftpUser);

		$form->remove('uid');
		$form->remove('username');
		$form->remove('firstname');
		$form->remove('lastname');
		$form->remove('home');
		$form->remove('shell');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('ftp_user_index', [
				'id_group' => $ftpGroup->getId(),
			]);
        }

        $em = $this->getDoctrine()->getManager();
		
        return $this->render('ftp_user/password.html.twig', [
            'ftp_user' => $ftpUser,
            'ftp_group' => $ftpGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id_group}/{id}", name="ftp_user_delete", methods="DELETE")
     * @ParamConverter("ftpGroup", options={"id" = "id_group"})
     */
    public function delete(Request $request, FtpUser $ftpUser, Ftpgroup $ftpGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ftpUser->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ftpUser);
            $em->flush();
        }

        $ftpGroup = $em->getRepository(FtpGroup::class)->find($ftpGroup);

		return $this->redirectToRoute('ftp_user_index', [
			'id_group' => $ftpGroup->getId()
		]);
    }
}
