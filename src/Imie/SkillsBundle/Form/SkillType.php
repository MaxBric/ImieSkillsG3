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
                ->add('skillName', null, array(
                    'label' => 'Nom de la compétence'
                ))
                ->add('skillDescription', null, array(
                    'label' => 'Description'
                ))
                ->add('skillParentId', 'entity', array(
                    'class' => 'ImieSkillsBundle:Skill',
                    'choice_label' => 'skillName',
                    'choice_value' => 'id',
                    'empty_value' => 'Choisissez...',
                    'required' => false,
                    'label' => 'Domaine de la compétence'
                ))
                ->add('Valider', 'submit')
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
