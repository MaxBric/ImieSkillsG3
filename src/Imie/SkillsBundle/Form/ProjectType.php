<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Imie\SkillsBundle\Form\ImageType;

class ProjectType extends AbstractType {
  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('projectName', null, array(
      'label' => 'Nom du projet :'
    ))
    ->add('state', 'entity', array(
      'class' => 'ImieSkillsBundle:State',
      'choice_label' => 'statut',
      'label' => 'Étape :'
    ))
    ->add('projectProgress', null, array(
      'label' => 'Progression de l\'étape (%) :'
    ))
    ->add('projectEstimatedStart', 'date', array(
      'format' => 'ddMMyyyy',
      'label' => 'Date de départ estimée :'
    ))
    ->add('projectEstimatedEnd', 'date', array(
      'format' => 'ddMMyyyy',
      'label' => 'Date de fin estimée :'
    ))
    ->add('projectStart', 'date', array(
      'format' => 'ddMMyyyy',
      'required' => false,
      'label' => 'Date de départ réelle :'
    ))
    ->add('projectEnd', 'date', array(
      'format' => 'ddMMyyyy',
      'required' => false,
      'label' => 'Date de fin réelle :'
    ))
    ->add('projectDescription',null, array(
      'label' => 'Description :'
    ))
    ->add('skills', 'entity', array(
      'class' => 'ImieSkillsBundle:Skill',
      'choice_label' => 'skillName',
      'multiple' => true,
      'label' => 'Compétences requises :'
    ))
    ->add('manager', 'entity', array(
      'class' => 'ImieSkillsBundle:User',
      'choice_label' => 'userFullName',
      'choice_value' => 'id',
      'empty_value' => 'Choisissez...',
      'required' => false,
      'label' => 'Chef de projet :'
    ))
    ->add('users', 'entity', array(
      'class' => 'ImieSkillsBundle:User',
      'choice_label' => 'userFullName',
      'choice_value' => 'id',
      'multiple' => true,
      'required' => false,
      'label' => 'Équipe : (vous faites déjà partie de l\'équipe en tant que Fondateur)'
    ))
    ->add('image', new ImageType(), array(
      'required' => false,
      'label' => 'Image :'
    ))
    ->add('Valider', 'submit', array(
      'attr' => array('class' => 'btn btn-primary'),
    ))
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
