<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom', // Étiquette du champ
                'attr' => [
                    'class' => 'form-control', // Attributs HTML du champ
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('age', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('image', FileType::class, [
                'data_class' => null, // Permet de gérer l'upload de fichiers
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'placeholder' => 'Merci de sélectionner un genre', // Option par défaut
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices'  => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Non genré' => 'Non genré',
                ]
            ])
            ->add('classroom', EntityType::class, [
                'class' => Classroom::class,
                'label' => 'Salle de cours',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => [
                    'class' => 'btn btn-success form-control',
                ]
            ])
            ->add('annuler', ButtonType::class, [
                'label' => 'Annuler',
                'attr' => [
                    'class' => 'btn btn-danger form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class, // Classe de données associée au formulaire
        ]);
    }
}
