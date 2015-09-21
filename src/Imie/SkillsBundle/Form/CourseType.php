<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Imie\SkillsBundle\Form\PromoType;
use Imie\SkillsBundle\Form\SchoolType;


class CourseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course')
            ->add('promos', 'entity', array(
                'class' => 'ImieSkillsBundle:Promo',
                'choice_label' => 'promoName',
                'multiple' => true
            ))
            ->add('school', 'entity', array(
                'class' => 'ImieSkillsBundle:School',
                'choice_label' => 'schoolName'
            ))
            ->add('envoyer','submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Imie\SkillsBundle\Entity\Course'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'imie_skillsbundle_course';
    }
}
