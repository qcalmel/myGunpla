<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/grade")
 */
class GradeController extends AbstractController
{
    /**
     * @Route("/", name="grade_index", methods={"GET"})
     */
    public function index(GradeRepository $gradeRepository): Response
    {
        return $this->render('grade/index.html.twig', [
            'grades' => $gradeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="grade_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grade);
            $entityManager->flush();

            return $this->redirectToRoute('grade_index');
        }

        return $this->render('grade/new.html.twig', [
            'grade' => $grade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grade_show", methods={"GET"})
     */
    public function show(Grade $grade): Response
    {
        return $this->render('grade/show.html.twig', [
            'grade' => $grade,
        ]);
    }

    /**
     * @Route("/scale/{id}", name="scale_allowed")
     */
    public function scaleByGrade(Request $request)
    {
    global $grade;
        if ($request->isXmlHttpRequest() && $request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $id = $request->get('id');

            $grade = $em->getRepository('App:Grade')->find($id);

            // create array for json response
            $scales = array();
            foreach ($grade->getScales() as $scale) {
                $scales[] = array($scale->getId(), $scale->getName());
            }
            dump($grade);
            $response = new Response(json_encode($scales));
            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
        return new Response();
    }

//    /**
//     ** @Route("/scale/{id}", name="scale_allowed")
//     */
//    public function scaleByGrade(Request $request)
//    {
//        if($request->isXmlHttpRequest()) {
//            $idGrade = $request->request->get('id');
//            $magasinDatas = //TES DONNEES;
//        return new JsonResponse($magasinDatas)
//    }
//
//    }

    /**
     * @Route("/{id}/edit", name="grade_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Grade $grade): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grade_index');
        }

        return $this->render('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grade_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Grade $grade): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grade->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grade);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grade_index');
    }
}
