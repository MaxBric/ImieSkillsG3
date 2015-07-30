<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\UserRepository")
 */
class User
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
     * @ORM\Column(name="userLastName", type="string", length=255)
     */
    private $userLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="userFirstName", type="string", length=255)
     */
    private $userFirstName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="userBirthday", type="datetime")
     */
    private $userBirthday;

    /**
     * @var integer
     *
     * @ORM\Column(name="userPhoneNumber", type="integer")
     */
    private $userPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="userMail", type="string", length=255)
     */
    private $userMail;

    /**
     * @var string
     *
     * @ORM\Column(name="userAddress", type="string", length=255)
     */
    private $userAddress;

    /**
     * @var boolean
     *
     * @ORM\Column(name="userEnable", type="boolean")
     */
    private $userEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="userLogin", type="string", length=255)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="userPassword", type="string", length=255)
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="userDescription", type="text")
     */
    private $userDescription;
  /**
  *  @var \Project
  *  @ORM\ManyToOne(targetEntity="Project", inversedBy="manager")
  */
    private $managedProjects;
    /**
    * @var \Project
    * @ORM\ManyToOne(targetEntity="Project", inversedBy="creator")
    */
    private $createdProjects;

    /**
    *@var \Project
    * @ORM\ManyToMany(targetEntity="Project", inversedBy="users" nullable=true)
    */
    private $joinedProjects;

    /**
    * @var \Level
    * @ORM\OneToMany(targetEntity="Level", mappedBy="userId")
    */
    private $skills;

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
     * Set userLastName
     *
     * @param string $userLastName
     * @return User
     */
    public function setUserLastName($userLastName)
    {
        $this->userLastName = $userLastName;

        return $this;
    }

    /**
     * Get userLastName
     *
     * @return string
     */
    public function getUserLastName()
    {
        return $this->userLastName;
    }

    /**
     * Set userFirstName
     *
     * @param string $userFirstName
     * @return User
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    /**
     * Get userFirstName
     *
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    /**
     * Set userBirthday
     *
     * @param \DateTime $userBirthday
     * @return User
     */
    public function setUserBirthday($userBirthday)
    {
        $this->userBirthday = $userBirthday;

        return $this;
    }

    /**
     * Get userBirthday
     *
     * @return \DateTime
     */
    public function getUserBirthday()
    {
        return $this->userBirthday;
    }

    /**
     * Set userPhoneNumber
     *
     * @param integer $userPhoneNumber
     * @return User
     */
    public function setUserPhoneNumber($userPhoneNumber)
    {
        $this->userPhoneNumber = $userPhoneNumber;

        return $this;
    }

    /**
     * Get userPhoneNumber
     *
     * @return integer
     */
    public function getUserPhoneNumber()
    {
        return $this->userPhoneNumber;
    }

    /**
     * Set userMail
     *
     * @param string $userMail
     * @return User
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;

        return $this;
    }

    /**
     * Get userMail
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * Set userAddress
     *
     * @param string $userAddress
     * @return User
     */
    public function setUserAddress($userAddress)
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * Get userAddress
     *
     * @return string
     */
    public function getUserAddress()
    {
        return $this->userAddress;
    }

    /**
     * Set userEnable
     *
     * @param boolean $userEnable
     * @return User
     */
    public function setUserEnable($userEnable)
    {
        $this->userEnable = $userEnable;

        return $this;
    }

    /**
     * Get userEnable
     *
     * @return boolean
     */
    public function getUserEnable()
    {
        return $this->userEnable;
    }

    /**
     * Set userLogin
     *
     * @param string $userLogin
     * @return User
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;

        return $this;
    }

    /**
     * Get userLogin
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userDescription
     *
     * @param string $userDescription
     * @return User
     */
    public function setUserDescription($userDescription)
    {
        $this->userDescription = $userDescription;

        return $this;
    }

    /**
     * Get userDescription
     *
     * @return string
     */
    public function getUserDescription()
    {
        return $this->userDescription;
    }
}
