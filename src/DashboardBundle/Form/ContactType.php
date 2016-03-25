<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('first_name',null,array(
                'required' => true
            ))
            ->add('last_name',null,array(
                'required' => true
            ))
            ->add('email',null,array(
                'required' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DashboardBundle\Entity\Contact'
        ));
    }
}
