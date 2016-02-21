<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('bedrooms')
            ->add('bathrooms')
            ->add('amenities')
            ->add('features')
            ->add('type')
            ->add('for_rent')
            ->add('leaseTerm')
            ->add('parking_spaces')
            ->add('lotSize')
            ->add('yearBuilt')
            ->add('address')
            ->add('unit')
            ->add('city')
            ->add('state')
            ->add('country')
            ->add('postalCode')
            ->add('lat')
            ->add('lng')
            ->add('list_price')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DashboardBundle\Entity\Property'
        ));
    }
}
