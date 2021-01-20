<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filter', EntityType::class, [
                "class" => "App\Entity\Filter",
                "placeholder" => "Choisissez un filtre",
                'choice_label' => 'name',
                'label' => false
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
