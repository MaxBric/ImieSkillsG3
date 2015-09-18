<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rank
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Rank
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
     * @ORM\Column(name="rankName", type="string", length=255)
     */
    private $rankName;

    /**
    * @var \User
    * @ORM\ManyToOne(targetEntity="User", inversedBy="ranks")
    */
    private $user;

 

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
     * Set rankName
     *
     * @param string $rankName
     * @return Rank
     */
    public function setRankName($rankName)
    {
        $this->rankName = $rankName;

        return $this;
    }

    /**
     * Get rankName
     *
     * @return string 
     */
    public function getRankName()
    {
        return $this->rankName;
    }

    /**
     * Set user
     *
     * @param \Imie\SkillsBundle\Entity\User $user
     * @return Rank
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
}
