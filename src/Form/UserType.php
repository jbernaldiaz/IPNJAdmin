<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Zonas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles',  ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'choices' => [
                    'Administrador' => 'ROLE_ADMIN',
                    'Supervisor' => 'ROLE_SUPER',
                    'Usuario' => 'ROLE_USER',
                ],
            ]) 
            ->add('password', PasswordType::class)
            ->add('iglesia', TextType::class)
            ->add('isActive', CheckboxType::class)
            ->add('zonas', EntityType::class, [
                'class' => Zonas::class,
                'choice_label' => 'zona'])
            ->add('save', SubmitType::class)
        ;
        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                 // transform the array to a string
                 return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
                 // transform the string back to an array
                 return [$rolesString];
            }
    ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
