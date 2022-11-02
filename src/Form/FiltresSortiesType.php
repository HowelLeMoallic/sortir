<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\FiltresSortiesFormModel;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltresSortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, [
                    'class' =>Campus::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')->orderBy('s.nom', 'ASC');
                    },
                    'choice_label' => 'nom',
                    'expanded' => false,
                    'multiple' => false
                ]
            )
            ->add('recherche', TextType::class, [
                'label' => 'Le nom de la sortie contient :'
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Entre',
                'widget' => 'single_text',



            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'et',
                'widget' => 'single_text',

            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur/trice',


            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis incrit/e',

            ])
            ->add('nonInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas incrit/e',

            ])
            ->add('sortiesPassees', CheckboxType::class, [
                'label' => 'Sorties passées',

            ])
            ->add('Recherche', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FiltresSortiesFormModel::class,
        ]);
    }
}
