<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Actif' => 'actif',
                    'Passif' => 'passif',
                ],
                'placeholder' => 'Choisissez un type',
                'label' => 'Type de transaction'
            ])
            ->add('montant', null, [
                'label' => 'Montant (en FCFA)'
            ])
            ->add('categorie', ChoiceType::class, [
                'choices'  => [
                    'Nourriture' => 'Nourriture',
                    'Transport' => 'Transport',
                    'Logement' => 'Logement',
                    'Santé' => 'Santé',
                    'Divertissement' => 'Divertissement',
                    'Salaire' => 'Salaire',
                    'Investissement' => 'Investissement',
                    'Autres' => 'Autres',
                ],
                'placeholder' => 'Sélectionnez une catégorie',
                'label' => 'Catégorie'
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date'
            ])
            ->add('description', null, [
                'required' => false,
                'label' => 'Description (facultatif)'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
