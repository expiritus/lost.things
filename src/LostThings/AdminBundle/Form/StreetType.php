<?php

namespace LostThings\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StreetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', null, array('label' => ' '))
            ->add('city', null, array('label' => ' '))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LostThings\AdminBundle\Entity\Street'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lostthings_adminbundle_street';
    }
}
