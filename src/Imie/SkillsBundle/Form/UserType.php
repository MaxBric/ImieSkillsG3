<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Imie\SkillsBundle\Form\RankType;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('userFirstName')
                ->add('userLastName')
                ->add('roles', new RankType)
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
                ->add('image', new ImageType())
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
