<?php

namespace App\Form;

use App\Entity\FtpGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FtpGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupname')
			->add('active', CheckboxType::class, array(
				'label'    => 'Activate',
				'required' => false,
			))
            ->add('gid', TextType::class, array(
                'disabled' => 'true'
            )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FtpGroup::class,
        ]);
    }
}
