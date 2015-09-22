<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserModifyType extends AbstractType {

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
                ->add('skills', 'entity', array(
                    'class' => 'ImieSkillsBundle:Skill',
                    'choice_label' => 'skillName',
                    'choice_value' => 'id',
                    'empty_value' => 'Choisissez...',
                    'required' => false
                ))
                ->add('userPhoneNumber', 'text')
                ->add('userMail', 'email')
                ->add('userAddress')
                ->add('userDescription')
                ->add('image', new ImageType())
                ->add('Ajouter', 'submit')
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
