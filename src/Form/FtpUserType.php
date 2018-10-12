<?php

namespace App\Form;

use App\Entity\FtpUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FtpUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('username')
            #->add('password', PasswordType::class)
			->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'invalid_message' => 'The password fields must match.',
				'options' => array('attr' => array('class' => 'password-field')),
				'required' => true,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password'),
			))
            ->add('home', TextType::class, array(
                #'disabled' => false,
				'required' => true,
            ))
			->add('active', CheckboxType::class, array(
				'label'    => 'Activate',
				'required' => false,
			))
			/*
            ->add('uid', TextType::class, array(
                'disabled' => 'true'
            ))
            ->add('shell', TextType::class, array(
                'disabled' => 'true'
            ))
            ->add('ftpgroup')
			*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FtpUser::class,
        ]);
    }
}
