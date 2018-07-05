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
     * @ParamConverter("ftpgroup", options={"id" = "id_group"})
     */
    public function index(FtpUserRepository $ftpUserRepository, Ftpgroup $ftpgroup): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ftpgroup = $em->getRepository(FtpGroup::class)->find($ftpgroup);

        if (!$ftpgroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpgroup->getId()
            );
        }

		return $this->render('ftp_user/index.html.twig', [
			'ftpgroup' => $ftpgroup,
			'ftp_users' => $ftpUserRepository->findAll()
		]);

    }

    /**
     * @Route("/new", name="ftp_user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $ftpUser = new FtpUser();
        $form = $this->createForm(FtpUserType::class, $ftpUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ftpUser);
            $em->flush();

            return $this->redirectToRoute('ftp_user_index');
        }

        return $this->render('ftp_user/new.html.twig', [
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
     * @Route("/{id}/edit", name="ftp_user_edit", methods="GET|POST")
     */
    public function edit(Request $request, FtpUser $ftpUser): Response
    {
        $form = $this->createForm(FtpUserType::class, $ftpUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ftp_user_edit', ['id' => $ftpUser->getId()]);
        }

        return $this->render('ftp_user/edit.html.twig', [
            'ftp_user' => $ftpUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ftp_user_delete", methods="DELETE")
     */
    public function delete(Request $request, FtpUser $ftpUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ftpUser->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ftpUser);
            $em->flush();
        }

        return $this->redirectToRoute('ftp_user_index');
    }
}
