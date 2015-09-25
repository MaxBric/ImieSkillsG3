<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('userFirstName', null, array(
      'label' => 'Prénom :'
    ))
    ->add('userLastName', null, array(
      'label' => 'Nom :'
    ))
    ->add('userBirthday', 'date', array(
      'format' => "ddMMyyyy",
      'label' => 'Date de naissance :'
    ))
    ->add('userPhoneNumber', 'integer', array(
      'label' => 'Numéro de téléphone :'
    ))
    ->add('userAddress', null, array(
      'label' => 'Adresse postale :'
    ))
    ->add('roles')
    ->add('email', 'email', array('label' => 'Email :', 'translation_domain' => 'FOSUserBundle'))
    ->add('username', null, array('label' => 'Pseudo :', 'translation_domain' => 'FOSUserBundle'))
    ->add('plainPassword', 'repeated', array(
      'type' => 'password',
      'options' => array('translation_domain' => 'FOSUserBundle'),
      'first_options' => array('label' => 'Mot de passe :'),
      'second_options' => array('label' => 'Confirmer le mot de passe :'),
      'invalid_message' => 'fos_user.password.mismatch',
    ))
    ->add('userDescription', null, array(
      'label' => 'Description :'
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
      'data_class' => 'Imie\SkillsBundle\Entity\User'
    ));
  }

  /**
  * @return string
  */
  public function getName() {
    return 'imie_skillsbundle_user';
  }
}
