<?php

namespace App\Controller;

use App\Entity\SerieType;
use App\Form\SerieTypeType;
use App\Repository\SerieTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/serie/type")
 */
class SerieTypeController extends AbstractController
{
    /**
     * @Route("/", name="serie_type_index", methods={"GET"})
     */
    public function index(SerieTypeRepository $serieTypeRepository): Response
    {
        return $this->render('serie_type/index.html.twig', [
            'serie_types' => $serieTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="serie_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $serieType = new SerieType();
        $form = $this->createForm(SerieTypeType::class, $serieType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serieType);
            $entityManager->flush();

            return $this->redirectToRoute('serie_type_index');
        }

        return $this->render('serie_type/new.html.twig', [
            'serie_type' => $serieType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="serie_type_show", methods={"GET"})
     */
    public function show(SerieType $serieType): Response
    {
        return $this->render('serie_type/show.html.twig', [
            'serie_type' => $serieType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="serie_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SerieType $serieType): Response
    {
        $form = $this->createForm(SerieTypeType::class, $serieType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('serie_type_index');
        }

        return $this->render('serie_type/edit.html.twig', [
            'serie_type' => $serieType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="serie_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SerieType $serieType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serieType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($serieType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('serie_type_index');
    }
}
