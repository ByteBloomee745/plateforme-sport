<?php

namespace App\Form;

use App\Entity\Entrainement;
use App\Entity\Equipe;
use App\Entity\Membre;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrainementForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'entraînement',
                'attr' => ['class' => 'form-control']
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu de l\'entraînement',
                'attr' => ['class' => 'form-control']
            ])
            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom',
                'label' => 'Équipe',
                'placeholder' => 'Sélectionnez une équipe',
                'attr' => ['class' => 'form-select']
            ])
            ->add('coach', EntityType::class, [
                'class' => Membre::class,
                'choice_label' => 'nomPrenom',
                'label' => 'Coach',
                'placeholder' => 'Sélectionnez un coach',
                'attr' => ['class' => 'form-select'],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->join('m.memberships', 'ms')
                        ->where('ms.role = :role')
                        ->setParameter('role', 'Coach');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrainement::class,
        ]);
    }
}
