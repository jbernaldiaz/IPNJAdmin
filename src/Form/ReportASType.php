<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReportASType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optionAnio)
    {
        $builder
        ->add('aporte', ChoiceType::class, array('choices' => array(
            'Aporte Voluntario 1'     => 'aporte_a' , 
            'Aporte Voluntario 2'   => 'aporte_b'
            )))

        ->add('anio', ChoiceType::class, array('choices' => $optionAnio["data"]["arrayResulMap"] ))
        ->add('save', SubmitType::class) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
