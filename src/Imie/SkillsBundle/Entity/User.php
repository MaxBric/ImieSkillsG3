<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Imie\SkillsBundle\Entity\Notification;
use Imie\SkillsBundle\Entity\Promo;
use Imie\SkillsBundle\Entity\UserSkill;
use Imie\SkillsBundle\Entity\Skill;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\UserRepository")
 * @UniqueEntity("userPhoneNumber")
 */
class User extends BaseUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="userLastName", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $userLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="userFirstName", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $userFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="userFullName", type="string", length=255)
     * 
     */
    private $userFullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="userBirthday", type="datetime")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $userBirthday;

    /**
     * @var integer
     *
     * @ORM\Column(name="userPhoneNumber", type="integer", unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "0",
     *      max = "10")
     */
    private $userPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="userAddress", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $userAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="userDescription", type="text", nullable=true)
     */
    private $userDescription;

    /**
     *  @var \Project
     *  @ORM\OneToMany(targetEntity="Project", mappedBy="manager")
     */
    private $managedProjects;

    /**
     * @var \Project
     * @ORM\OneToMany(targetEntity="Project", mappedBy="creator")
     */
    private $createdProjects;

    /**
     * @var \Project
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="users")
     */
    private $joinedProjects;

    /**
     * @var \UserSkill
     * @ORM\OneToMany(targetEntity="UserSkill", mappedBy="userId")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     *
     */
    private $skills;

    /**
     * @var \Notification
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="notificationUser")
     */
    private $notifications;

    /**
     * @var \Promo
     * @ORM\ManyToOne(targetEntity="Promo", inversedBy="users")
     */
    private $promo;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     *
     */
    protected $image;

    public function __construct() {
        parent::__construct();
        $this->createdProjects = new ArrayCollection();
        $this->managedProjects = new ArrayCollection();
        $this->joinedProjects = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->userBirthday = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set userLastName
     *
     * @param string $userLastName
     * @return User
     */
    public function setUserLastName($userLastName) {
        $this->userLastName = ucfirst($userLastName);

        return $this;
    }

    /**
     * Get userLastName
     *
     * @return string
     */
    public function getUserLastName() {
        return $this->userLastName;
    }

    /**
     * Set userFirstName
     *
     * @param string $userFirstName
     * @return User
     */
    public function setUserFirstName($userFirstName) {
        $this->userFirstName = ucfirst($userFirstName);

        return $this;
    }

    /**
     * Get userFirstName
     *
     * @return string
     */
    public function getUserFirstName() {
        return $this->userFirstName;
    }

    /**
     * Set userBirthday
     *
     * @param \DateTime $userBirthday
     * @return User
     */
    public function setUserBirthday($userBirthday) {
        $this->userBirthday = $userBirthday;

        return $this;
    }

    /**
     * Get userBirthday
     *
     * @return \DateTime
     */
    public function getUserBirthday() {
        // var_dump($this->userBirthday);die();
        return $this->userBirthday;
    }

    /**
     * Set userPhoneNumber
     *
     * @param integer $userPhoneNumber
     * @return User
     */
    public function setUserPhoneNumber($userPhoneNumber) {
        $this->userPhoneNumber = $userPhoneNumber;

        return $this;
    }

    /**
     * Get userPhoneNumber
     *
     * @return integer
     */
    public function getUserPhoneNumber() {
        return $this->userPhoneNumber;
    }

    /**
     * Set userAddress
     *
     * @param string $userAddress
     * @return User
     */
    public function setUserAddress($userAddress) {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * Get userAddress
     *
     * @return string
     */
    public function getUserAddress() {
        return $this->userAddress;
    }


    /**
     * Set userDescription
     *
     * @param string $userDescription
     * @return User
     */
    public function setUserDescription($userDescription) {
        $this->userDescription = $userDescription;

        return $this;
    }

    /**
     * Get userDescription
     *
     * @return string
     */
    public function getUserDescription() {
        return $this->userDescription;
    }

    /**
     * Add managedProjects
     *
     * @param \Imie\SkillsBundle\Entity\Project $managedProjects
     * @return User
     */
    public function addManagedProject(\Imie\SkillsBundle\Entity\Project $managedProjects) {
        $this->managedProjects[] = $managedProjects;

        return $this;
    }

    /**
     * Remove managedProjects
     *
     * @param \Imie\SkillsBundle\Entity\Project $managedProjects
     */
    public function removeManagedProject(\Imie\SkillsBundle\Entity\Project $managedProjects) {
        $this->managedProjects->removeElement($managedProjects);
    }

    /**
     * Get managedProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getManagedProjects() {
        return $this->managedProjects;
    }

    /**
     * Add createdProjects
     *
     * @param \Imie\SkillsBundle\Entity\Project $createdProjects
     * @return User
     */
    public function addCreatedProject(\Imie\SkillsBundle\Entity\Project $createdProjects) {
        $this->createdProjects[] = $createdProjects;

        return $this;
    }

    /**
     * Remove createdProjects
     *
     * @param \Imie\SkillsBundle\Entity\Project $createdProjects
     */
    public function removeCreatedProject(\Imie\SkillsBundle\Entity\Project $createdProjects) {
        $this->createdProjects->removeElement($createdProjects);
    }

    /**
     * Get createdProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreatedProjects() {
        return $this->createdProjects;
    }

    /**
     * Add joinedProjects
     *
     * @param \Imie\SkillsBundle\Entity\Project $joinedProjects
     * @return User
     */
    public function addJoinedProject(\Imie\SkillsBundle\Entity\Project $joinedProjects) {
        $this->joinedProjects[] = $joinedProjects;
        $joinedProjects->addUser($this);

        return $this;
    }

    /**
     * Remove joinedProjects
     *
     * @param \Imie\SkillsBundle\Entity\Project $joinedProjects
     */
    public function removeJoinedProject(\Imie\SkillsBundle\Entity\Project $joinedProjects) {
        $this->joinedProjects->removeElement($joinedProjects);
    }

    /**
     * Get joinedProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoinedProjects() {
        return $this->joinedProjects;
    }

   
    /**
     * Add notifications
     *
     * @param \Imie\SkillsBundle\Entity\Notification $notifications
     * @return User
     */
    public function addNotification(\Imie\SkillsBundle\Entity\Notification $notifications) {
        $this->notifications[] = $notifications;

        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \Imie\SkillsBundle\Entity\Notification $notifications
     */
    public function removeNotification(\Imie\SkillsBundle\Entity\Notification $notifications) {
        $this->notifications->removeElement($notifications);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications() {
        return $this->notifications;
    }

   

    public function setUserFullName() {
        $this->userFullName = $this->userFirstName . ' ' . $this->userLastName;
        return $this;
    }

    public function getUserFullName() {
        return $this->userFullName;
    }

    /**
     * Set image
     *
     * @param \Imie\SkillsBundle\Entity\Image $image
     * @return Produit
     */
    public function setImage(\Imie\SkillsBundle\Entity\Image $image = null) {
        $this->image = $image;
        $image->setImageAlt($this->getUserFirstName() . $this->getUserLastName());

        return $this;
    }

    /**
     * Get image
     *
     * @return \Imie\SkillsBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }

<<<<<<< HEAD
=======

    /**
     * Set promo
     *
     * @param \Imie\SkillsBundle\Entity\Promo $promo
     * @return User
     */
    public function setPromo(\Imie\SkillsBundle\Entity\Promo $promo = null)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return \Imie\SkillsBundle\Entity\Promo 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Add skills
     *
     * @param \Imie\SkillsBundle\Entity\UserSkill $skills
     * @return User
     */
    public function addSkill($skill, $level)
    {
        $this->skills[$skill] = $level;
     
        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Imie\SkillsBundle\Entity\UserSkill $skills
     */
    public function removeSkill(\Imie\SkillsBundle\Entity\UserSkill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSkills()
    {
        return $this->skills;
    }
    
 


>>>>>>> 180a37950b1e099305845e2e0565d0784a3df489
}
