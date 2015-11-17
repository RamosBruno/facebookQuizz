<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', [
                'label' => 'Prénom',
            ])
            ->add('lastname', 'text', [
                'label' => 'Nom',
            ])
            ->add('email', 'email', [
                'label' => 'Email',
            ])
            ->add('username', 'text', [
                'label' => 'Login',
            ])
            ->add('roles', 'choice', [
                'label' => 'Roles',
                'multiple' => true,
                'choices' => [
                    'ROLE_ADMIN' => 'Admin',
                    'ROLE_SUPER_ADMIN' => 'Super admin', ],
            ])
        ;
        if ($options['newUser']) {
            $builder->add('plainPassword', 'repeated', [
                'type' => 'password',
                'label' => 'Mot de passe',
                'options' => ['translation_domain' => 'FOSUserBundle'],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter'],
                'invalid_message' => 'Mot de passe non identique',
            ]);
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'newUser' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
