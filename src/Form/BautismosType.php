<?php

namespace App\Form;

use App\Entity\Bautismos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class BautismosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaAt', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy', 
                'html5' => false,
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
        ]])
            ->add('nombre', TextType::class)
            ->add('bautizo', TextType::class)
            ->add('fotos', FileType::class, [
                'label' => 'Agregue las fotos del bautismo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                'multiple' => true,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k'
                        
                ])
                 
                 ]])
            ->add('save', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bautismos::class,
        ]);
    }
}
