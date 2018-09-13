<?php

namespace App\Controller;

use App\Entity\FtpHistory;
use App\Entity\FtpUser;
use App\Entity\FtpGroup;

use App\Form\FtpHistoryType;
use App\Repository\FtpHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/ftp/history")
 */
class FtpHistoryController extends Controller
{
    /**
     * @Route("/", name="ftp_history_index", methods="GET")
     */
    /**
     * @Route("/{id_group}/{id_user}", name="ftp_history_index", methods="GET")
     * @ParamConverter("ftpGroup", options={"id" = "id_group"})
     * @ParamConverter("ftpUser", options={"id" = "id_user"})
     */
    public function index(FtpHistoryRepository $ftpHistoryRepository, Ftpgroup $ftpGroup, Ftpuser $ftpUser, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ftpGroup = $em->getRepository(FtpGroup::class)->find($ftpGroup);

        if (!$ftpGroup) {
            throw $this->createNotFoundException(
                'No ftp group found for id '.$ftpGroup->getId()
            );
        }

        $ftpUser = $em->getRepository(FtpUser::class)->find($ftpUser);

        if (!$ftpUser) {
            throw $this->createNotFoundException(
                'No ftp user found for id '.$ftpUser->getId()
            );
        }
/*
		return $this->render('ftp_history/index.html.twig', [
			'ftp_group' => $ftpGroup,
			'ftp_user' => $ftpUser,
			#'ftp_histories' => $ftpHistoryRepository->findAll(),
			#'ftp_histories' => $ftpHistoryRepository->findByUserId($ftpUser->getId())
			'ftp_histories' => $ftpHistoryRepository->findByUserAndGroupId($ftpUser->getId(), $ftpGroup->getId())
		]);
 */

		$ftpHistoryRepository = $em->getRepository(FtpHistory::class);
		$allFtpHistoryQuery = $ftpHistoryRepository->findByUserAndGroupIdPaginator($ftpUser->getId(), $ftpGroup->getId());
		$paginator = $this->get('knp_paginator');
		$ftp_histories = $paginator->paginate(
			$allFtpHistoryQuery,
			$request->query->getInt('page', 1)
		); 

		return $this->render('ftp_history/index.html.twig', [
			'ftp_group'		=> $ftpGroup,
			'ftp_user'		=> $ftpUser,
			'ftp_histories' => $ftp_histories
		]);
    }

    /**
     * @Route("/new", name="ftp_history_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $ftpHistory = new FtpHistory();
        $form = $this->createForm(FtpHistoryType::class, $ftpHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ftpHistory);
            $em->flush();

            return $this->redirectToRoute('ftp_history_index');
        }

        return $this->render('ftp_history/new.html.twig', [
            'ftp_history' => $ftpHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ftp_history_show", methods="GET")
     */
    public function show(FtpHistory $ftpHistory): Response
    {
        return $this->render('ftp_history/show.html.twig', ['ftp_history' => $ftpHistory]);
    }

    /**
     * @Route("/{id}/edit", name="ftp_history_edit", methods="GET|POST")
     */
    public function edit(Request $request, FtpHistory $ftpHistory): Response
    {
        $form = $this->createForm(FtpHistoryType::class, $ftpHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ftp_history_edit', ['id' => $ftpHistory->getId()]);
        }

        return $this->render('ftp_history/edit.html.twig', [
            'ftp_history' => $ftpHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ftp_history_delete", methods="DELETE")
     */
    public function delete(Request $request, FtpHistory $ftpHistory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ftpHistory->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ftpHistory);
            $em->flush();
        }

        return $this->redirectToRoute('ftp_history_index');
    }
}
