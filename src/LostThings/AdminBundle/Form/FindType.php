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
//            ->add('fileName')
            ->add('country', null, array('label' => ' '))
            ->add('city', null, array('label' => ' '))
            ->add('area', null, array('label' => ' '))
            ->add('street', null, array('label' => ' '))
            ->add('thing', null, array('label' => ' '))
            ->add('username', null, array('label' => ' '))
            ->add('description', null, array('label' => ' '))
            ->add('status')
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
