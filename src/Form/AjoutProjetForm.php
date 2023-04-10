<?php

namespace App\Form;

// use App\Entity\User;
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class AjoutProjetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom')
            // ->add('description')
            // ->add('image',FileType::class, array('mapped' => false))
            // ->add('date')

            ->add('nom', null, [
                'attr' => [
                    'placeholder' => 'Nom du projet'
                ],
                'label' => false,
            ])
            ->add('description', null, [
                'attr' => [
                    'placeholder' => 'Description'
                ],
                'label' => false,
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => false,
            ])
            ->add('date', BirthdayType::class, [
                'label' => false,
                'placeholder' => [
                    'day' => 'Jour',
                    'month' => 'Mois',
                    'year' => 'Année',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
