<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Imie\SkillsBundle\Entity\UserSkill;
use Imie\SkillsBundle\Entity\User;

/**
 * Skill
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\SkillRepository")
 * @UniqueEntity("skillName")
 */
class Skill
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
     * @ORM\Column(name="skillName", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $skillName;

    /**
     * @var string
     *
     * @ORM\Column(name="skillDescription", type="string", length=255, nullable=true)
     */
    private $skillDescription;

    /**
     * @var integer
     * @ORM\Column(name="skillParentId", type="integer", nullable=true)
     */
    private $skillParentId;

    /**
     * @var \UserSkill
     * @ORM\OneToMany(targetEntity="UserSkill", mappedBy="skill")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $users;

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
     * Set skillName
     *
     * @param string $skillName
     * @return Skill
     */
    public function setSkillName($skillName)
    {
        $this->skillName = $skillName;

        return $this;
    }

    /**
     * Get skillName
     *
     * @return string
     */
    public function getSkillName()
    {
        return $this->skillName;
    }

    /**
     * Set skillDescription
     *
     * @param string $skillDescription
     * @return Skill
     */
    public function setSkillDescription($skillDescription)
    {
        $this->skillDescription = $skillDescription;

        return $this;
    }

    /**
     * Get skillDescription
     *
     * @return string
     */
    public function getSkillDescription()
    {
        return $this->skillDescription;
    }

    /**
     * Set skillParentId
     *
     * @param integer $skillParentId
     * @return Skill
     */
    public function setSkillParentId($skillParentId)
    {
        $this->skillParentId = $skillParentId->getId();

        return $this;
    }

    /**
     * Get skillParentId
     *
     * @return integer
     */
    public function getSkillParentId()
    {
        return $this->skillParentId;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \Imie\SkillsBundle\Entity\UserSkill $users
     * @return Skill
     */
    public function addUser(\Imie\SkillsBundle\Entity\UserSkill $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Imie\SkillsBundle\Entity\UserSkill $users
     */
    public function removeUser(\Imie\SkillsBundle\Entity\UserSkill $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
