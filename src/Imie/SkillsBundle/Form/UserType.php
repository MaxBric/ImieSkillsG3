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
                ->add('userFirstName')
                ->add('userLastName')
                ->add('userBirthday', 'date', array(
                    'format' => "ddMMyyyy"
                ))
                ->add('userPhoneNumber', 'text')
                ->add('email', 'email')
//            ->add('userMail', 'email')
                ->add('userAddress')
                ->add('userEnable')
//            ->add('userLogin')
                ->add('username')
                ->add('password', 'password')
//            ->add('userPassword', 'password')
                ->add('userDescription')
                ->add('image', new ImageType(), array(
                    'required' => false
                ))
                ->add('Add', 'submit')
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
