<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('nameShort')
            ->add('era',EntityType::class,[
                "class"=>"App\Entity\Era",
                'choice_label'=>'name',
                'required'=>false
            ])
            ->add('serieType',EntityType::class,[
                "class"=>"App\Entity\SerieType",
                'choice_label'=>'name',
                'required'=>false
            ])
            ->add('mainSerie',EntityType::class,[
                "class"=>"App\Entity\Serie",
                'choice_label'=>'name',
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
