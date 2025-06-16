<?php

namespace App\Form;

use App\Entity\MatchGame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Equipe;
use App\Entity\Competition;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date du match',
            ])
            ->add('scoreA', IntegerType::class, [
                'label' => 'Score Équipe A',
            ])
            ->add('scoreB', IntegerType::class, [
                'label' => 'Score Équipe B',
            ])
            ->add('equipeA', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom',
                'label' => 'Équipe A',
            ])
            ->add('equipeB', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom',
                'label' => 'Équipe B',
            ])
            ->add('competition', EntityType::class, [
                'class' => Competition::class,
                'choice_label' => 'nom',
                'label' => 'Compétition',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MatchGame::class,
        ]);
    }
}


