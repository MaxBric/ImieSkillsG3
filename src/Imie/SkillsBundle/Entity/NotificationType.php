<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\NotificationTypeRepository")
 */
class NotificationType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="notificationTypeName", type="string", length=255)
     */
    private $notificationTypeName;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set notificationTypeName
     *
     * @param string $notificationTypeName
     * @return NotificationType
     */
    public function setNotificationTypeName($notificationTypeName)
    {
        $this->notificationTypeName = $notificationTypeName;

        return $this;
    }

    /**
     * Get notificationTypeName
     *
     * @return string 
     */
    public function getNotificationTypeName()
    {
        return $this->notificationTypeName;
    }
}
