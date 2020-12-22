<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Scale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('nameShort')
            ->add('logo',FileType::class,[
                'multiple'=>false,
                'mapped'=>false,
                'required'=>false
            ])
            ->add('allowed_scales',EntityType::class,[
                'class'=>'App\Entity\Scale',
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}
