<?php

namespace App\Form;

use App\Entity\EnviosFN;
use App\Entity\User;
use App\Entity\Zonas;
use DateTime;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType as TypeDateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnviosFNType extends AbstractType
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
            'years' => range(2020,2030,1),
            'attr' => ['data-date-format' => 'yyyy', ] ])
            ->add('operacion', TextType::class)
            ->add('cajero', TextType::class)
            ->add('dDiezmo', IntegerType::class)
            ->add('fSolidario', IntegerType::class)
            ->add('cuotaSocio', IntegerType::class)
            ->add('diezmoPersonal', IntegerType::class)
            ->add('misionera', IntegerType::class)
            ->add('rayos', IntegerType::class)
            ->add('gavillas', IntegerType::class)
            ->add('fmn', IntegerType::class)
            ->add('total', IntegerType::class)  
            ->add('save', ButtonType::class, array(
                'attr' => array(
                        'onclick' => 'confirmAdd()'
                ))) 
                   
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnviosFN::class,
        ]);
    }
    
}
