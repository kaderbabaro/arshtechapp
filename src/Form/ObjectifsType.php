<?php

namespace App\Form;

use App\Entity\Objectifs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectifsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Description')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('createdAT', null, [
                'widget' => 'single_text',
            ])
            ->add('titre')
            ->add('montant', IntegerType::class, [
                    'label' => 'Montant',
                    'attr' => [
                    'class' => 'form-control',
                   
            'min' => 0, // optionnel
        ],
    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objectifs::class,
        ]);
    }
}
