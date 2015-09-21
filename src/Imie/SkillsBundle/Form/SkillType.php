<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SkillType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('skillName')
                ->add('skillDescription')
                ->add('skillParentId', 'entity', array(
                    'class' => 'ImieSkillsBundle:Skill',
                    'choice_label' => 'skillName',
                    'choice_value' => 'id',
                    'empty_value' => 'Choisir...',
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
            'data_class' => 'Imie\SkillsBundle\Entity\Skill'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'imie_skillsbundle_skill';
    }

}
