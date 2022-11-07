<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ParticipantType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('pseudo', TextType::class,[
                'label' => 'Pseudo :'
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom :'
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom :'
            ])
            ->add('telephone', TextType::class,[
                'label' => 'Téléphone :'
            ])
            ->add('mail', EmailType::class,[
                'label' => 'Email :'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe ne correspond pas à sa confirmation.',
                'first_options' => [
                    'label' => 'Mot de passe :',
                   // 'help' => 'Le mot de passe doit contenir au minimum 8 caractères dont une minuscule, une majuscule, un chiffre et un caractère spécial.',
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe :',
                ],
                'mapped' => false,
                'required' => false,
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Veuillez renseigner un mot de passe.',
//                    ]),
//                ]
            ])
            ->add('campus', EntityType::class, [
                'class' =>Campus::class,
                    'label' => 'Campus :',

                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')->orderBy('s.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false
                ]
            )
            ->add('image', FileType::class, [
                'label' => 'Image (format jpg ou png)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Un format jpg ou png est attendu',
                    ])
                ],
            ])
            ->add('Enregister', SubmitType::class, )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
