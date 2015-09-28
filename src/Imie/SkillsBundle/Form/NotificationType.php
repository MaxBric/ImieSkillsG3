<?php

namespace Imie\SkillsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                ->add('notificationType', 'entity', array(
                    'class' => 'ImieSkillsBundle:NotificationType',
                    'choice_label' => 'notificationTypeName',
                    'choice_value' => 'id',
                    'label' => 'Type notification',
                ))
                ->add('notificationUser', 'entity', array(
                    'class' => 'ImieSkillsBundle:User',
                    'choice_label' => 'userFullName',
                    'choice_value' => 'id',
                    'label' => 'utilisateur concerné',
                ))
                ->add('notificationProject', 'entity', array(
                    'class' => 'ImieSkillsBundle:Project',
                    'choice_label' => 'projectName',
                    'choice_value' => 'id',
                    'label' => 'projet concerné',
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
