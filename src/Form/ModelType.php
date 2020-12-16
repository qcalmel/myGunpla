<?php

namespace App\Form;

use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('version')
            ->add('date')
            ->add('price')
            ->add('nbPart')
            ->add('gradeNumber')
            ->add('codeJAN')
            ->add('description')
            ->add('unit',EntityType::class,[
                'class'=>'App\Entity\Unit',
                'choice_label'=>'name',
                'multiple'=> true,
            ])
            ->add('grade',EntityType::class,[
                'class'=>'App\Entity\Grade',
                'choice_label'=>'name',
                'multiple'=> false,
            ])
            ->add('scale',EntityType::class,[
                'class'=>'App\Entity\Scale',
                'choice_label'=>'name',
                'multiple'=> false
            ])
            ->add('primaryColor',EntityType::class,[
                'class'=>'App\Entity\ModelColor',
                'choice_label'=>'name',
                'multiple'=> true,
            ])
            ->add('secondaryColor',EntityType::class,[
                'class'=>'App\Entity\ModelColor',
                'choice_label'=>'name',
                'multiple'=> true,
            ])
            ->add('tags',EntityType::class,[
                'class'=>'App\Entity\Tag',
                'choice_label'=>'name',
                'multiple'=> true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
