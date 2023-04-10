<?php

namespace App\Form;

use App\Entity\AC;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ACFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, [
                'attr' => ['placeholder' => 'Label']
            ])
            // ->add('competence', null, [
            //     'attr' => ['placeholder' => 'Nom de la compétence']
            // ])
            ->add('competence', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Comprendre' => 'Comprendre',
                    'Concevoir' => 'Concevoir',
                    'Exprimer' => 'Exprimer',
                    'Développer' => 'Developper',
                    'Entreprendre' => 'Entreprendre',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'placeholder' => 'Sélectionnez une compétence',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
     
            ->add('description', null, [
                'attr' => ['placeholder' => 'Description officielle']
            ])
            // ->add('niveau', null, [
            //     'attr' => ['placeholder' => 'Niveau (de 1 à 3)']
            // ])
            ->add('niveau', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
                'placeholder' => 'Sélectionnez un niveau',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AC::class,
        ]);
    }
}
