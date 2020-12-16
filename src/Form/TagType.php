<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category',EntityType::class,[
                'label'=>"Catégorie existante",
                'class'=>'App\Entity\CategoryTag',
                'choice_label'=>'name',
                'multiple'=> false,
            ])
//            ->add('categoryNew',CategoryTagType::class,[
//                'label'=>'Nouvelle catégorie',
//                'property_path'=>'category',
//                'required'=>false
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
