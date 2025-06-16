<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Sport;
use App\Entity\Membre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom',
                'required' => true,
                'placeholder' => 'Sélectionnez un sport',
                'empty_data' => null,
                'group_by' => 'type',
                'attr' => [
                    'class' => 'form-select'
                ],
                'choice_attr' => function($choice) {
                    return ['class' => 'sport-option'];
                }
            ])
            ->add('coach', EntityType::class, [
                'class' => Membre::class,
                'choice_label' => 'nomPrenom',
                'label' => 'Coach',
                'placeholder' => 'Sélectionnez un coach',
                'required' => false,
                'attr' => ['class' => 'form-select']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
