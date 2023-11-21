<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Discipline;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Nom', // Étiquette du champ
                'attr' => [
                    'class' => 'form-control', // Attributs HTML du champ
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prénom',
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
            ->add('disciplines', EntityType::class, [
                'class' => Discipline::class, // Classe associée pour les options déroulantes
                'multiple' => true, // Permet la sélection multiple
                'expanded' => true, // Affiche les options comme des cases à cocher
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class, // Classe de données associée au formulaire
        ]);
    }
}
