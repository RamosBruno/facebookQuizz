<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', 'text', [
                'label' => 'Question',
                'required' => true,
            ])
            ->add('response1', 'text', [
                'label' => 'Réponse 1',
                'required' => true,
            ])
            ->add('response2', 'text', [
                'label' => 'Réponse 2',
                'required' => true,
            ])
            ->add('response3', 'text', [
                'label' => 'Réponse 3',
                'required' => false,
            ])
            ->add('response4', 'text', [
                'label' => 'Réponse 4',
                'required' => false,
            ])
            ->add('responseValide', 'number', [
                'label' => 'Numéro de la bonne réponse',
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
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_question';
    }
}
