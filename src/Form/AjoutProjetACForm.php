<?php

namespace App\Form;

use App\Entity\ProjetAC;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;


class AjoutProjetACForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('project_name', TextType::class, [
            //     'label' => false,
            //     'required' => true,
            // ])
            ->add('label', ChoiceType::class, [
                'choices' => $options['ac_choices'],
                'choice_label' => function ($ac) {
                    return $ac->getLabel() . ' (' . $ac->getDescription() . ')';
                },
                'placeholder' => 'Choisir un AC',
                'choice_value' => 'id',
                'label' => false,
                'required' => false,
                // 'attr' => [
                //     'name' => 'select_',
                // ]
                
            ])
            ->add('note', IntegerType::class, [
                'label' => false,
                
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'placeholder' => 'Note (0-20)',
                    // 'name' => 'note_nom',
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('ac_choices');
        $resolver->setAllowedTypes('ac_choices', 'iterable');
        $resolver->setDefaults([
            'data_class' => ProjetAC::class,
        ]);
    }
}
