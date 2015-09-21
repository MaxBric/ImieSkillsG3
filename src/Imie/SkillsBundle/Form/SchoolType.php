<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Imie\SkillsBundle\Form\CourseType;

class SchoolType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('schoolName')
            ->add('courses', 'entity', array(
                'class' => 'ImieSkillsBundle:Course',
                'choice_label' => 'course',
                'multiple' =>true,
                'required'=>false
            ))
            ->add('Ajouter','submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Imie\SkillsBundle\Entity\School'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'imie_skillsbundle_school';
    }
}
