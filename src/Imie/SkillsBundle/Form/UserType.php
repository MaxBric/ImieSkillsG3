<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
<<<<<<< HEAD
        ->add('userFirstName')
        ->add('userLastName')
        ->add('userBirthday', 'date', array(
        'format' => "ddMMyyyy"
        ))
        ->add('userPhoneNumber', 'text')
        ->add('userAddress')
        ->add('userDescription')
        ->add('image', new ImageType(), array(
        'required' => false
        ))
        ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
        ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
        ->add('plainPassword', 'repeated', array(
        'type' => 'password',
        'options' => array('translation_domain' => 'FOSUserBundle'),
        'first_options' => array('label' => 'form.password'),
        'second_options' => array('label' => 'form.password_confirmation'),
        'invalid_message' => 'fos_user.password.mismatch',
        ))
        ->add('Add', 'submit')
=======
            ->add('userFirstName')
            ->add('userLastName')
            ->add('userBirthday', 'date', array(
              'format' => "ddMMyyyy"
            ))
            ->add('userPhoneNumber', 'text')
            ->add('userMail', 'email')
            ->add('userAddress')
            ->add('userEnable')
            ->add('userLogin')
            ->add('userPassword', 'password')
            ->add('userDescription')
            ->add('image',  new ImageType(), array(
                'required' => false
            ))
            ->add('Ajouter', 'submit')
>>>>>>> cf10b660188dc23902d7f07f1d4abd27fa1588e8
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Imie\SkillsBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'imie_skillsbundle_user';
    }

}
