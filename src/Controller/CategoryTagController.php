<?php

namespace App\Controller;

use App\Entity\CategoryTag;
use App\Form\CategoryTagType;
use App\Repository\CategoryTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/tag")
 */
class CategoryTagController extends AbstractController
{
    /**
     * @Route("/", name="category_tag_index", methods={"GET"})
     */
    public function index(CategoryTagRepository $categoryTagRepository): Response
    {
        return $this->render('category_tag/index.html.twig', [
            'category_tags' => $categoryTagRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="category_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryTag = new CategoryTag();
        $form = $this->createForm(CategoryTagType::class, $categoryTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryTag);
            $entityManager->flush();

            return $this->redirectToRoute('category_tag_index');
        }

        return $this->render('category_tag/new.html.twig', [
            'category_tag' => $categoryTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_tag_show", methods={"GET"})
     */
    public function show(CategoryTag $categoryTag): Response
    {
        return $this->render('category_tag/show.html.twig', [
            'category_tag' => $categoryTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryTag $categoryTag): Response
    {
        $form = $this->createForm(CategoryTagType::class, $categoryTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_tag_index');
        }

        return $this->render('category_tag/edit.html.twig', [
            'category_tag' => $categoryTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_tag_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoryTag $categoryTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_tag_index');
    }
}
