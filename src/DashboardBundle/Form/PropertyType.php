<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use DashboardBundle\DBAL\Types\PropertyEnumType;

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
            ->add('type', ChoiceType::class, array(
                'choices' => PropertyEnumType::getChoices(),
                'attr' => array('class' => 'select2'),
                'empty_data' => null,
                'empty_value' => 'Select unit type'
            ))
            ->add('for_rent')
            ->add('lease_term')
            ->add('parking_spaces')
            ->add('unit_size')
            ->add('year_built')
            ->add('address')
            ->add('unit')
            ->add('city')
            ->add('state')
            ->add('country')
            ->add('postal_code')
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
