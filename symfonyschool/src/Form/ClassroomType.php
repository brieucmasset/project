<?php

namespace App\Form;

use App\Entity\Classroom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',  // Étiquette du champ
                'attr' => [
                    'class' => 'form-control',  // Classes CSS pour le champ
                ]
            ])
            ->add('capacity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',  // Classes CSS pour le champ
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder',  // Étiquette du bouton
                'attr' => [
                    'class' => 'btn btn-success form-control',  // Classes CSS pour le bouton
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,  // Classe de l'entité associée au formulaire
        ]);
    }
}
