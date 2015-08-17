<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projectName')
            ->add('state')
            ->add('projectEstimatedStart', 'date')
            ->add('projectEstimatedEnd', 'date')
            ->add('projectStart', 'date')
            ->add('projectEnd', 'date')
            ->add('projectDescription')
            ->add('projectProgress', 'percent')
            ->add('skills', 'entity', array(
                'class'=> 'ImieSkillsBundle:Skill',
                'choice_label' => 'skillName',
                'multiple' => true
            ))
            ->add('manager', 'entity', array(
                'class' => 'ImieSkillsBundle:User',
                'choice_label' => 'userFullName'
            ))
            ->add('users', 'entity', array(
                'class' => 'ImieSkillsBundle:User',
                'choice_label' => 'userFullName'
            ))
            ->add('Valider', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Imie\SkillsBundle\Entity\Project'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'imie_skillsbundle_project';
    }
}
