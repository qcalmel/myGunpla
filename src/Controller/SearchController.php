<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search5", name="search")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchNavbar()
    {
        $form =  $this->createFormBuilder(null)
            ->add('query',TextType::class,[
                'label'=>false
            ])
            ->add(('search'),SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('navbar.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
