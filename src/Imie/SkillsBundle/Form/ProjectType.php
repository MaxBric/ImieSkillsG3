<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('projectName')
                ->add('state', 'entity', array(
                    'class' => 'ImieSkillsBundle:State',
                    'choice_label' => 'statut'))
                ->add('projectProgress')
                ->add('projectEstimatedStart', 'date', array(
                    'format' => 'ddMMyyyy',
                ))
                ->add('projectEstimatedEnd', 'date', array(
                    'format' => 'ddMMyyyy',
                ))
                ->add('projectStart', 'date', array(
                    'format' => 'ddMMyyyy',
                    'required' => false
                ))
                ->add('projectEnd', 'date', array(
                    'format' => 'ddMMyyyy',
                    'required' => false
                ))
                ->add('projectDescription')
                ->add('skills', 'entity', array(
                    'class' => 'ImieSkillsBundle:Skill',
                    'choice_label' => 'skillName',
                    'multiple' => true
                ))
                ->add('manager', 'entity', array(
                    'class' => 'ImieSkillsBundle:User',
                    'choice_label' => 'userFullName',
                    'choice_value' => 'id',
                    'empty_value' => 'Choisissez une option',
                    'required' => false
                ))
                ->add('users', 'entity', array(
                    'class' => 'ImieSkillsBundle:User',
                    'choice_label' => 'userFullName',
                    'choice_value' => 'id',
                    'multiple' => true,
                    'required' => false
                ))
                ->add('image', new ImageType(), array(
                    'required' => false
                ))
                ->add('Ajouter', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Imie\SkillsBundle\Entity\Project'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'imie_skillsbundle_project';
    }

}
