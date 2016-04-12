<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlyerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', null, array( 'required' => true ))
            ->add('sender_name', null, array(
                'required' => true,
                'label' => 'Sender Name',
            ))
            ->add('email', null, array(
              'required' => true,
              'label' => 'Sender email',
            ))
            ->add('email_reply', null, array(
                'required' => true,
            ))
            ->add('subject', null, array( 'required' => true ))
            ->add('message', null, array(
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DashboardBundle\Entity\Flyer'
        ));
    }
}
