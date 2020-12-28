<?php

namespace App\Form;


use App\Entity\Filter;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvancedSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filters',CollectionType::class,[
                'entry_type' => FilterType::class,
                'allow_add' => true
            ]);
//            ->add('filter', EntityType::class, [
//                "class" => "App\Entity\Filter",
//                "placeholder" => "Choisissez un filtre",
//                'choice_label'=>'name'
//            ])
//            ->add('condition', EntityType::class, [
//                "class" => "App\Entity\FilterCondition",
//                'choice_label'=>'name',
//                'label'=>false
//            ])->add('entity_option', ChoiceType::class, [
//                'label'=>false,
//                'required'=>false,
//            ])
//            ->add('text_option', TextType::class, [
//                'label'=>false,
//                'required'=>false
//            ])
//        ;
//        $builder->get('entity_option')->resetViewTransformers();


        $builder
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
