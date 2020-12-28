<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Model;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
//    /**
//     * @var EntityManagerInterface
//     */
//    private $manager;
//
//    public function __construct(EntityManagerInterface $manager)
//    {
//        $this->manager = $manager;
//    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filter', EntityType::class, [
                "class" => "App\Entity\Filter",
                "placeholder" => "Choisissez un filtre",
                'choice_label' => 'name'
            ])
            ->add('condition', EntityType::class, [
                "class" => "App\Entity\FilterCondition",
                'choice_label' => 'name',
                'label' => false
            ])->add('entity_option', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'attr' => ["style" => "display:none"]
            ])
            ->add('text_option', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ["style" => "display:none"]
            ]);
        $builder->get('entity_option')->resetViewTransformers();
//        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
//            $form = $event->getForm();
//            $optionType = $form->get('filter')->getData()->getFormType();
//            if ($optionType != 'price') {
//                $optionId = $form->get('entity_option')->getData();
//
//                $entity = $this->manager->getRepository('App:' . $optionType)->find($optionId);
//                dump('1');
//                $formOptions = [
//                    'class' => 'App:' . $optionType,
//                    'label' => false,
//                    'required' => false,
//                ];
//                $form->remove('entity_option');
//                $form->add('entity_option', EntityType::class, $formOptions);
//                $form->get('entity_option')->setData($entity);
//
//
//            }
//
//        }
//        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
