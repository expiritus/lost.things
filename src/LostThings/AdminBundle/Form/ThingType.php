<?php

namespace LostThings\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameThing', null, array('label' => ' '))
            ->add('baseThing', 'checkbox', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LostThings\AdminBundle\Entity\Thing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lostthings_adminbundle_thing';
    }
}
