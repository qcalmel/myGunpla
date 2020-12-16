<?php

namespace App\Controller;

use App\Entity\Scale;
use App\Form\ScaleType;
use App\Repository\ScaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/scale")
 */
class ScaleController extends AbstractController
{
    /**
     * @Route("/", name="scale_index", methods={"GET"})
     */
    public function index(ScaleRepository $scaleRepository): Response
    {
        return $this->render('scale/index.html.twig', [
            'scales' => $scaleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="scale_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $scale = new Scale();
        $form = $this->createForm(ScaleType::class, $scale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scale);
            $entityManager->flush();

            return $this->redirectToRoute('scale_index');
        }

        return $this->render('scale/new.html.twig', [
            'scale' => $scale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scale_show", methods={"GET"})
     */
    public function show(Scale $scale): Response
    {
        return $this->render('scale/show.html.twig', [
            'scale' => $scale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="scale_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Scale $scale): Response
    {
        $form = $this->createForm(ScaleType::class, $scale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scale_index');
        }

        return $this->render('scale/edit.html.twig', [
            'scale' => $scale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scale_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Scale $scale): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scale->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('scale_index');
    }
}
