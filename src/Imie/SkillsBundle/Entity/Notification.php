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
     * @ORM\Column(name="notificationDate", type="datetime")
     */
    private $notificationDate;

    /**
     * @var string
     * @ORM\Column(name="notificationDescription", type="string")
     */
    private $notificationDescription;

    /**
     * @var \NotificationType
     * @ORM\ManyToOne(targetEntity="NotificationType")
     */
    private $notificationType;

    /**
     * @var \User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
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

    /**
     * Set notificationType
     *
     * @param \Imie\SkillsBundle\Entity\NotificationType $notificationType
     * @return Notification
     */
    public function setNotificationType(\Imie\SkillsBundle\Entity\NotificationType $notificationType = null)
    {
        $this->notificationType = $notificationType;

        return $this;
    }

    /**
     * Get notificationType
     *
     * @return \Imie\SkillsBundle\Entity\NotificationType
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * Get notificationUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotificationUser()
    {
        return $this->notificationUser;
    }

    /**
     * Set notificationUser
     *
     * @param \Imie\SkillsBundle\Entity\User $notificationUser
     * @return Notification
     */
    public function setNotificationUser(\Imie\SkillsBundle\Entity\User $notificationUser = null)
    {
        $this->notificationUser = $notificationUser;

        return $this;
    }
}
