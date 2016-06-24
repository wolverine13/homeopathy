<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Fixtures\ChoiceSubType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('f_name', TextType::class, array( 'label' => 'First Name' ) )
            ->add('l_name', TextType::class, array('label' => 'Last Name'))
            ->add('email')
            ->add('username')
            ->add('password', RepeatedType::class, array(
                 'type' => PasswordType::class,
                 'first_options'  => array('label' => 'Password'),
                 'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('role', EntityType::class, array(
                    'class' => 'AppBundle:Role', 'choice_label' => 'name'
                )
            );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
