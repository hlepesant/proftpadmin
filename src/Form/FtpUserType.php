<?php

namespace App\Form;

use App\Entity\FtpUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FtpUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('password')
            ->add('uid')
            ->add('home')
            ->add('shell')
            ->add('ftpgroup')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FtpUser::class,
        ]);
    }
}
