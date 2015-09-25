<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserSkillType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('skill', 'entity', array(
                    'class' => 'ImieSkillsBundle:Skill',
                    'choice_label' => 'skillName',
                    'label' => 'Compétence'
                ))
                ->add('level', 'entity', array(
                    'class' => 'ImieSkillsBundle:Level',
                    'choice_label' => 'level',
                    'choice_value' => 'id',
                    'label' => 'Niveau'
                ))
                ->add('Valider', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Imie\SkillsBundle\Entity\UserSkill'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'imie_skillsbundle_userskill';
    }

}
