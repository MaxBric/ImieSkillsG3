<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="projectName", type="string", length=255)
     */
    private $projectName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="projectEstimatedEnd", type="datetime")
     */
    private $projectEstimatedEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="projectStart", type="datetime")
     */
    private $projectStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="projectEnd", type="datetime")
     */
    private $projectEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="projectEstimatedStart", type="datetime")
     */
    private $projectEstimatedStart;

    /**
     * @var integer
     *
     * @ORM\Column(name="projectProgress", type="integer")
     */
    private $projectProgress;

    /**
     * @var string
     *
     * @ORM\Column(name="projectDescription", type="text")
     */
    private $projectDescription;

    /**
     * @var \User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="managedProjects")
     */
    private $manager;

    /**
     * @var \User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="createdProjects")
     */
    private $creator;

    /**
     * @var \User
     * @ORM\ManyToMany(targetEntity="User", mappedBy="joinedProjects")
     */
    private $users;

    /**
     * @var \State
     * @ORM\OneToOne(targetEntity="State")
     */
    private $state;

    /**
     * @var \Skill
     * @ORM\ManyToMany(targetEntity="Skill")
     */
    private $skills;


    public function __construct() {
        $this->skills = \Doctrine\Common\Collections\ArrayCollection();
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
     * Set projectName
     *
     * @param string $projectName
     * @return Project
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set projectEstimatedEnd
     *
     * @param \DateTime $projectEstimatedEnd
     * @return Project
     */
    public function setProjectEstimatedEnd($projectEstimatedEnd)
    {
        $this->projectEstimatedEnd = $projectEstimatedEnd;

        return $this;
    }

    /**
     * Get projectEstimatedEnd
     *
     * @return \DateTime
     */
    public function getProjectEstimatedEnd()
    {
        return $this->projectEstimatedEnd;
    }

    /**
     * Set projectStart
     *
     * @param \DateTime $projectStart
     * @return Project
     */
    public function setProjectStart($projectStart)
    {
        $this->projectStart = $projectStart;

        return $this;
    }

    /**
     * Get projectStart
     *
     * @return \DateTime
     */
    public function getProjectStart()
    {
        return $this->projectStart;
    }

    /**
     * Set projectEnd
     *
     * @param \DateTime $projectEnd
     * @return Project
     */
    public function setProjectEnd($projectEnd)
    {
        $this->projectEnd = $projectEnd;

        return $this;
    }

    /**
     * Get projectEnd
     *
     * @return \DateTime
     */
    public function getProjectEnd()
    {
        return $this->projectEnd;
    }

    /**
     * Set projectEstimatedStart
     *
     * @param \DateTime $projectEstimatedStart
     * @return Project
     */
    public function setProjectEstimatedStart($projectEstimatedStart)
    {
        $this->projectEstimatedStart = $projectEstimatedStart;

        return $this;
    }

    /**
     * Get projectEstimatedStart
     *
     * @return \DateTime
     */
    public function getProjectEstimatedStart()
    {
        return $this->projectEstimatedStart;
    }

    /**
     * Set projectProgress
     *
     * @param integer $projectProgress
     * @return Project
     */
    public function setProjectProgress($projectProgress)
    {
        $this->projectProgress = $projectProgress;

        return $this;
    }

    /**
     * Get projectProgress
     *
     * @return integer
     */
    public function getProjectProgress()
    {
        return $this->projectProgress;
    }

    /**
     * Set projectDescription
     *
     * @param string $projectDescription
     * @return Project
     */
    public function setProjectDescription($projectDescription)
    {
        $this->projectDescription = $projectDescription;

        return $this;
    }

    /**
     * Get projectDescription
     *
     * @return string
     */
    public function getProjectDescription()
    {
        return $this->projectDescription;
    }


    /**
     * Remove manager
     *
     * @param \Imie\SkillsBundle\Entity\User $manager
     */
    public function removeManager(\Imie\SkillsBundle\Entity\User $manager)
    {
        $this->manager->removeElement($manager);
    }

    /**
     * Get manager
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getManager()
    {
        return $this->manager;
    }



    /**
     * Remove creator
     *
     * @param \Imie\SkillsBundle\Entity\User $creator
     */
    public function removeCreator(\Imie\SkillsBundle\Entity\User $creator)
    {
        $this->creator->removeElement($creator);
    }

    /**
     * Get creator
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Add users
     *
     * @param \Imie\SkillsBundle\Entity\User $users
     * @return Project
     */
    public function addUser(\Imie\SkillsBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Imie\SkillsBundle\Entity\User $users
     */
    public function removeUser(\Imie\SkillsBundle\Entity\User $users)
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

    /**
     * Set state
     *
     * @param \Imie\SkillsBundle\Entity\State $state
     * @return Project
     */
    public function setState(\Imie\SkillsBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Imie\SkillsBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add skills
     *
     * @param \Imie\SkillsBundle\Entity\Skill $skills
     * @return Project
     */
    public function addSkill(\Imie\SkillsBundle\Entity\Skill $skills)
    {
        $this->skills[] = $skills;

        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Imie\SkillsBundle\Entity\Skill $skills
     */
    public function removeSkill(\Imie\SkillsBundle\Entity\Skill $skills)
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

    /**
     * Set manager
     *
     * @param \Imie\SkillsBundle\Entity\User $manager
     * @return Project
     */
    public function setManager(\Imie\SkillsBundle\Entity\User $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Set creator
     *
     * @param \Imie\SkillsBundle\Entity\User $creator
     * @return Project
     */
    public function setCreator(\Imie\SkillsBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }
}
