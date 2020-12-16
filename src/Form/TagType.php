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
            ->add('category',CategoryTagType::class,[
                'label'=>'Nouvelle catégorie',
                ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
