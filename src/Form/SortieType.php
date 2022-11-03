<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('organisateur', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => 'pseudo',
                'disabled' => true
            ])
            ->add('nom', TextType::class, [
                'disabled' => true,
                'label' => 'Nom'
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'disabled' => true,
                'label' => 'Date de Début',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('duree', TimeType::class,[
                'disabled' => true,
                'label' => 'Durée',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('dateLimiteInscription', DateTimeType::class, [
                'disabled' => true,
                'label' => 'Date limite d\'inscription',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('nbInscriptionMax', NumberType::class,[
                'disabled' => true,
                'label' => 'Nombre d\'inscriptions Max'
            ])
            ->add('infosSortie', TextareaType::class,[
                'disabled' => true,
                'label' => 'Infos Sortie'
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'disabled' => true
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
