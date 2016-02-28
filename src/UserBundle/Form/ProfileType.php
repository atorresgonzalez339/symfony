<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use UserBundle\DBAL\Types\GenderType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('gender', ChoiceType::class, array(
                'choices' => GenderType::getChoices(),
                'attr' => array('class' => 'select2 validate'),
                'empty_data' => null,
                'required'    => false,
                'placeholder' => 'Select Gender',
            ))
            ->add('birth_date',null,array(
                'widget' => 'single_text',
                'attr' => array(
                    'type'=>'text',
                ),
                'required' => false,
            ))
            ->add('cell_phone')
            ->add('office_phone')
            ->add('email')
            ->add('company')
            ->add('address')
            ->add('city')
            ->add('state')
            ->add('country')
            ->add('website')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\UserProfile'
        ));
    }
}
