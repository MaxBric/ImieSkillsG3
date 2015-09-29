<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Imie\SkillsBundle\Form\CourseType;

class PromoType extends AbstractType {
  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('promoName', null, array(
      'label' => 'Promo :'
    ))
    ->add('course', 'entity', array(
      'class' => 'ImieSkillsBundle:Course',
      'choice_label' => 'courseFullName',
      'label' => 'Cursus :'
    ))
    ->add('Valider','submit', array(
      'attr' => array('class' => 'btn btn-primary'),
    ))
    ;
  }
  /**
  * @param OptionsResolverInterface $resolver
  */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Imie\SkillsBundle\Entity\Promo'
    ));
  }

  /**
  * @return string
  */
  public function getName() {
    return 'imie_skillsbundle_promo';
  }
}
