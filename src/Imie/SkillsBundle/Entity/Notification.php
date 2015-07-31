<?php

namespace Imie\SkillsBundle\Entity;
use Imie\SkillsBundle\Entity\NotificationType;
use Imie\SkillsBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\NotificationRepository")
 */
class Notification {

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
     * @ORM\Column(name="notificationName", type="string", length=255)
     */
    private $notificationName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notificationDate", type="date")
     */
    private $notificationDate;

    /**
     * @var string
     * @ORM\Column(name="notificationDescription", type="string")
     */
    private $notificationDescription;

    /**
     * @var NotificationType
     * ORM\ManyToOne(targetEntity="NotificationType")
     */
    private $notificationType;

    /**
     * @var User
     * ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     */
    private $notificationUser;

    public function __construct() {
        $this->notificationDate = new \DateTime("now");
    }
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
     * Set notificationName
     *
     * @param string $notificationName
     * @return Notification
     */
    public function setNotificationName($notificationName)
    {
        $this->notificationName = $notificationName;

        return $this;
    }

    /**
     * Get notificationName
     *
     * @return string 
     */
    public function getNotificationName()
    {
        return $this->notificationName;
    }

    /**
     * Set notificationDate
     *
     * @param \DateTime $notificationDate
     * @return Notification
     */
    public function setNotificationDate($notificationDate)
    {
        $this->notificationDate = $notificationDate;

        return $this;
    }

    /**
     * Get notificationDate
     *
     * @return \DateTime 
     */
    public function getNotificationDate()
    {
        return $this->notificationDate;
    }

    /**
     * Set notificationDescription
     *
     * @param string $notificationDescription
     * @return Notification
     */
    public function setNotificationDescription($notificationDescription)
    {
        $this->notificationDescription = $notificationDescription;

        return $this;
    }

    /**
     * Get notificationDescription
     *
     * @return string 
     */
    public function getNotificationDescription()
    {
        return $this->notificationDescription;
    }
}
