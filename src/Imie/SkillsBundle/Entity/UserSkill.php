<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSkill
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\UserSkillRepository")
 */
class UserSkill
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="skills")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Skill", inversedBy="users")
     */
    private $skill;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;


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
     * Set level
     *
     * @param integer $level
     * @return UserSkill
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set user
     *
     * @param \Imie\SkillsBundle\Entity\User $user
     * @return UserSkill
     */
    public function setUser(\Imie\SkillsBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Imie\SkillsBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set skill
     *
     * @param \Imie\SkillsBundle\Entity\Skill $skill
     * @return UserSkill
     */
    public function setSkill(\Imie\SkillsBundle\Entity\Skill $skill = null)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Imie\SkillsBundle\Entity\Skill 
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
