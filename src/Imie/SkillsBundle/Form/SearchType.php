<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('text', null, array(
      'attr' => array(
      'placeholder' => 'Entrer nom de projet, nom d\'utilisateur ou compétence.'
      ),
      'label' => false)
      )
      ->add('type', 'choice', array(
        'choices' => array('Project' => 'Projet', 'User' => 'Utilisateur', 'Skill' => 'Compétence'),
        'multiple' => true
      ))
      ->add('Add', 'submit')
      ;
    }

    /**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'Imie\SkillsBundle\Entity\Search'
      ));
    }

    /**
    * @return string
    */
    public function getName()
    {
      return 'imie_skillsbundle_search';
    }
  }
