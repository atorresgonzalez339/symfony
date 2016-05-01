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
            ->add('email_reply', null, array(
                'required' => true,
            ))
            ->add('subject', null, array( 'required' => true ))
            ->add('message', null, array(
                'required' => false,
            ))
            ->add('address', 'hidden', array(
                'required' => false
            ))
            ->add('map_active', 'hidden', array(
                'required' => false,
            ))
            ->add('lat', 'hidden', array(
                'required' => false,
            ))
            ->add('lng', 'hidden', array(
                'required' => false,
            ))
            ->add('map_zoom', 'hidden', array(
                'required' => false,
            ))
            ->add('map_center_lat', 'hidden', array(
              'required' => false,
            ))
            ->add('map_center_lng', 'hidden', array(
              'required' => false,
            ))
            ->add('html_edit', 'hidden', array(
                'required' => false,
            ))
            ->add('html', 'hidden', array(
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
