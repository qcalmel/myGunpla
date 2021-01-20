<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\Model;
use App\Entity\Picture;
use App\Entity\Scale;
use App\Entity\Serie;
use App\Entity\Unit;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/model")
 */
class ModelController extends AbstractController
{
    private function getPagination($source, PaginatorInterface $paginator, Request $request){
        return $pagination = $paginator->paginate(
            $source,
            $request->query->getInt('page',1),
            10

        );
    }
    /**
     * @Route("/json_add", name="model_json_add", methods={"GET","POST"})
     */
    public function addModelFromJSON(Request $request){
        $form = $this->createFormBuilder(null)
            ->add('json_file',FileType::class,[
                'label'=>"Fichier JSON",
            ])
            ->add(('add'),SubmitType::class,[
                'label'=>'Importer',
                'attr'=>[
                    'class'=>'btn btn-primary'
                ],
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $JSONData = file_get_contents($form->get('json_file')->getData());
            $data = json_decode($JSONData,true);
            $entityManager = $this->getDoctrine()->getManager();
            $grade = $this->getDoctrine()->getRepository(Grade::class)->find(14);
            foreach ($data as $modelData){
                $model = new Model();
                $price = str_replace(array('¥',','), '',$modelData['price']);
                $model->setName($modelData["sub_name"])
                    ->setGrade($grade)
                    ->setPrice(intval($price))
                    ->addPicture((new Picture())->setName($modelData['img']))
                    //TODO ne pas créer d'entité Picture quand il n'y pas pas d'image
                    ->setDescription($modelData['notes'])
                    ->setScale($this->getDoctrine()->getRepository(Scale::class)->find(12))
                    ->setGradeNumber($modelData['grade_number']);
                try {
                    $model->setDate((new \DateTime($modelData['date'])));
                } catch (Exception $e) {
                    dump("date error for model".$modelData['sub_name']);
                }
                $unit = $this->getDoctrine()->getRepository(Unit::class)->findOneBy(['name'=>$modelData["name"]]);
                $serie = $this->getDoctrine()->getRepository(Serie::class)->findOneBy(['name'=>$modelData["serie"]]);
                if($modelData['name'] != null) {
                    if ($unit == null) {
                        $unit = new Unit();
                        $unit->setName($modelData['name']);
                        if ($serie == null) {
                            $serie = new Serie();
                            $serie->setName($modelData["serie"]);
                            $entityManager->persist($serie);
                        }
                        $unit->addSerie($serie);
                        $entityManager->persist($unit);
                    }
                    $model->addUnit($unit);
                    $entityManager->flush();
                }
                $entityManager->persist($model);
            }
            $entityManager->flush();
             $message = "fichier ok";
        }

            return $this->render('/model/add.html.twig', [
                'form' => $form->createView(),
                'message' => $message ?? null
            ]);


    }

    /**
     * @Route("/", name="model_index", methods={"GET"})
     */
    public function index(ModelRepository $modelRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $this->getPagination(
            $modelRepository->findAll(),
            $paginator,
            $request
        );
        $totalModels = $modelRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('model/index.html.twig', [
            'models' => $pagination,
            'total' => $totalModels
        ]);
    }

    /**
     * @Route("/new", name="model_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();
            // On boucle sur les images
            foreach($pictures as $picture){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$picture->guessExtension();

                // On copie le fichier dans le dossier uploads
                $picture->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $pic = new Picture();
                $pic->setName($fichier);
                $model->addPicture($pic);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('model_index');
        }

        return $this->render('model/new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="model_show", methods={"GET"})
     */
    public function show(Model $model): Response
    {
        return $this->render('model/show.html.twig', [
            'model' => $model,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="model_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Model $model): Response
    {
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form->get('pictures')->getData();
            // On boucle sur les images
            foreach($pictures as $picture){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$picture->guessExtension();

                // On copie le fichier dans le dossier uploads
                $picture->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $pic = new Picture();
                $pic->setName($fichier);
                $model->addPicture($pic);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('model_index');
        }

        return $this->render('model/edit.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="model_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Model $model): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($model);
            $entityManager->flush();
        }

        return $this->redirectToRoute('model_index');
    }

    /**
     * @Route("/delete/picture/{id}", name="model_delete_picture", methods={"DELETE"})
     */
    public function deleteImage(Picture $picture, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $picture->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * @Route("/search", name="model_search")
     */
    public function modelSearch(Request $request){
        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('model_search'))
            ->add('query',TextType::class,[
                'label'=>false
            ])
            ->add(('search'),SubmitType::class,[
                'label'=> 'Rechercher',
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $query = $form->get('query')->getData();
            $models = $this->getDoctrine()->getRepository(Model::class)->findByName($query);
            return $this->render('model/search.html.twig',[
                'models' => $models
            ]);
        }
        else {
            return $this->render('navbar.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

}
