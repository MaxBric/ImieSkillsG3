<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Imie\SkillsBundle\Form\UserType;

class NotificationType extends AbstractType {
  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('notificationName', null, array(
      'label' => 'Titre :'
    ))
    ->add('notificationDescription', null, array(
      'label' => 'Description :'
    ))
    ->add('notificationUser', null, array(
      'label' => 'Nom d\'utilisateur :'
    ))
    ->add('Envoyer', 'submit', array(
      'attr' => array('class' => 'btn btn-primary'),
    ))
    ;
  }

  /**
  * @param OptionsResolverInterface $resolver
  */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Imie\SkillsBundle\Entity\Notification'
    ));
  }

  /**
  * @return string
  */
  public function getName() {
    return 'imie_skillsbundle_notification';
  }
}
