<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('Utilisateur', ChoiceType::class, [
                'choices'  => [
                    'Sita Hassimi' => 'Sita Hassimi',
                    'Souleymane Tidjani' => 'Souleymane Tidjani',
                    'Dignon Bertin' => 'Dignon Bertin',
                    'Hadiza Abdoulaye' => 'Dignon Bertin',
                    'Kader Babaro' => 'Kader Babaro',
                ],
                'placeholder' => 'Sélectionnez un utilisateur',
                'label' => 'Statut'
                ])
            ->add('description')
            ->add('statut', ChoiceType::class, [
                'choices'  => [
                    'Executée' => 'Executée',
                    'En-cours' => 'En-cours',
                    'Non-executée' => 'Non-executée',
                ],
                'placeholder' => 'Sélectionnez un statut',
                'label' => 'Statut'
                ])
            ->add('priorite', ChoiceType::class, [
                'choices'  => [
                    'Prioritaire' => 'Élevée',
                    'Semi-Prioritaire' => 'Moyenne',
                    'Pas-Prioritaire' => 'Basse',
                ],
                'placeholder' => 'Sélectionnez une priorité',
                'label' => 'Priorité'
                ])
            ->add('date_echeance', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
