<?php

namespace ProftpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FtpuserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname')
            ->add('lastname')
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('uid', TextType::class, array(
                'disabled' => 'true'
            ))
            ->add('home', TextType::class, array(
                'disabled' => 'true'
            ))
            ->add('shell', TextType::class, array(
                'disabled' => 'true'
            ));
            #->add('group'); //, HiddenType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProftpBundle\Entity\Ftpuser'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'proftpbundle_ftpuser';
    }


}
