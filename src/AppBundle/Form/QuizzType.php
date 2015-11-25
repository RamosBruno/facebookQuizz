<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuizzType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => 'Name',
                'required' => true,
            ])
            ->add('description', 'textarea', [
                'label' => 'Description',
                'required' => true,
            ])
            ->add('gains', 'textarea', [
                'label' => 'Gains du quizz',
                'required' => true,
            ])
            ->add('numberOfWinner', 'number', [
                'label' => 'Nombre de gagnants',
                'required' => true,
            ])
            ->add('dateStart', 'date', [
                'label' => 'Date de début du quizz',
                'required' => true,
            ])
            ->add('dateEnd', 'date', [
                'label' => 'Date de fin du quizz',
                'required' => true,
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Quizz'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_quizz';
    }
}
