<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfigurationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => 'Nom du site',
                'required' => true
            ])
            ->add('imageFile', 'vich_image', [
                'label' => 'Logo/Avatar',
                'allow_delete' => false,
                'download_link' => false,
                'required' => false,
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Configuration'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_configuration';
    }
}
