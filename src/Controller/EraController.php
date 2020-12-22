<?php

namespace App\Controller;

use App\Entity\Era;
use App\Form\EraType;
use App\Repository\EraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/era")
 */
class EraController extends AbstractController
{
    /**
     * @Route("/", name="era_index", methods={"GET"})
     */
    public function index(EraRepository $eraRepository): Response
    {
        return $this->render('era/index.html.twig', [
            'eras' => $eraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="era_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $era = new Era();
        $form = $this->createForm(EraType::class, $era);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($era);
            $entityManager->flush();

            return $this->redirectToRoute('era_index');
        }

        return $this->render('era/new.html.twig', [
            'era' => $era,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="era_show", methods={"GET"})
     */
    public function show(Era $era): Response
    {
        return $this->render('era/show.html.twig', [
            'era' => $era,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="era_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Era $era): Response
    {
        $form = $this->createForm(EraType::class, $era);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('era_index');
        }

        return $this->render('era/edit.html.twig', [
            'era' => $era,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="era_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Era $era): Response
    {
        if ($this->isCsrfTokenValid('delete'.$era->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($era);
            $entityManager->flush();
        }

        return $this->redirectToRoute('era_index');
    }
}
