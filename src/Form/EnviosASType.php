<?php

namespace App\Form;

use App\Entity\EnviosAS;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnviosASType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('fecha', DateType::class, [
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy', 
            'html5' => false,
            'attr' => [
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy'
    ]])
                    
       ->add('mes', ChoiceType::class, array('choices' => array(
            'Enero'     => 'Enero' , 
            'Febrero'   => 'Febrero', 
            'Marzo'     => 'Marzo', 
            'Abril'     => 'Abril', 
            'Mayo'      => 'Mayo', 
            'Junio'     => 'Junio', 
            'Julio'     => 'Julio', 
            'Agosto'    => 'Agosto', 
            'Septiembre'=> 'Septiembre', 
            'Octubre'   => 'Octubre', 
            'Noviembre' => 'Noviembre', 
            'Diciembre' => 'Diciembre'
            )))

           ->add('anio', DateType::class, [
            'widget' => 'choice',
            'years' => range(date('Y')-1,date('Y')+1,1),
            'attr' => ['data-date-format' => 'yyyy', ] ])
            ->add('operacion', TextType::class)
            ->add('cajero', TextType::class)
            ->add('aporteA', IntegerType::class)
            ->add('aporteB', IntegerType::class)
            ->add('total', IntegerType::class)  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnviosAS::class,
        ]);
    }
}
