<?php

namespace LostThings\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FindType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countryId')
            ->add('cityId')
            ->add('areaId')
            ->add('streetId')
            ->add('thingId')
            ->add('userId')
            ->add('status')
            ->add('dateFind')
            ->add('description')
            ->add('fileName')
            ->add('country')
            ->add('city')
            ->add('area')
            ->add('street')
            ->add('thing')
            ->add('username')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LostThings\AdminBundle\Entity\Find'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lostthings_adminbundle_find';
    }
}
