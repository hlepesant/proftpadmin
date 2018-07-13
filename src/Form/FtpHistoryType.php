<?php

namespace App\Form;

use App\Entity\FtpHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FtpHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client_ip')
            ->add('server_ip')
            ->add('command')
            ->add('file')
            ->add('status')
            ->add('date')
            ->add('ftpuser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FtpHistory::class,
        ]);
    }
}
