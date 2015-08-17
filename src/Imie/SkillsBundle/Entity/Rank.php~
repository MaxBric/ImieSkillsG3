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
     * @ORM\Column(name="rank", type="string", length=255)
     */
    private $rank;

    /**
    * @var \User
    * @ORM\ManyToOne(targetEntity="User", inversedBy="rank")
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
     * Set rank
     *
     * @param string $rank
     * @return Rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set users
     *
     * @param \Imie\SkillsBundle\Entity\User $users
     * @return Rank
     */
    public function setUsers(\Imie\SkillsBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \Imie\SkillsBundle\Entity\User
     */
    public function getUsers()
    {
        return $this->users;
    }
}
