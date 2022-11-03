<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Model\FiltresSortiesFormModel;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
                    'required' => false,
                ]
            )
            ->add('recherche', SearchType::class, [
                'label' => 'Le nom de la sortie contient :',
                'required' => false,

            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Entre',
                'widget' => 'single_text',
                'required' => false,


            ])
            ->add('dateFin', DateType::class, [
                'label' => 'et',
                'widget' => 'single_text',
                'required' => false,


            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur/trice',
                'required' => false


            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis incrit/e',
                'required' => false

            ])
            ->add('nonInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas incrit/e',
                'required' => false

            ])
            ->add('sortiesPassees', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false
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
