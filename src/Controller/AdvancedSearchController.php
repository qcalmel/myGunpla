<?php

namespace App\Controller;

use App\Entity\AdvancedSearch;
use App\Entity\Filter;
use App\Entity\FilterCondition;
use App\Entity\Model;
use App\Form\AdvancedSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvancedSearchController extends AbstractController
{
    /**
     * @Route("/advanced/search", name="advanced_search")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(AdvancedSearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des champs qui ne sont pas lié a une entité
            $selectedOption = [];
            $submitedData = $form->getData()['filters'];

            foreach ($submitedData as $index=>$filter){
                $selectedOption[$index] = $filter['entity_option'];
            }
            $models = $this->getDoctrine()->getRepository(Model::class)->findByFilter($submitedData);
        }

        return $this->render('advanced_search/index.html.twig', [
            'form' => $form->createView(),
            'selected'=>$selectedOption ?? null,
            'models'=>$models ?? null
        ]);
    }
    /**
     * @Route("/advanced/filter/{id}", name="filter_conditions")
     */
    public function filterConditions(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $id = $request->get('id');

            $filter = $em->getRepository('App:Filter')->find($id);

            // create array for json response
            $conditions = array();
            $optionType = $filter->getFormType();
            foreach ($filter->getConditions() as $condition) {
                $conditions[] = array($condition->getId(), $condition->getName());
            }
            $options = $optionType;
            if($optionType != 'price' && $optionType != 'name'){
                $options = array();
                $items = $em->getRepository('App:' . $optionType)->findAll();
                foreach ($items as $item) {
                    $options[] = array($item->getId(), $item->getName());
                }
            }
            $result = ['conditions'=>$conditions,'option'=>$options];
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');


            return $response;
        }
        return new Response();
    }
}
