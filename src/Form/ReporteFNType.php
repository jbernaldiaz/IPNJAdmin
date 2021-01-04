<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteOfrendasNacionalesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $optionAnio)
    {  
        
        $builder
        ->add('ofrenda', ChoiceType::class, array('choices' => array(
            'Misionera'     => 'misionera' , 
            'Gavillas'   => 'gavillas', 
            'Rayos'     => 'rayos',
            'FMN' => 'fmn'
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
