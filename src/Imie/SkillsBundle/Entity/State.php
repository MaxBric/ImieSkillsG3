<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\StateRepository")
 */
class State
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
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var integer
     *
     * @ORM\Column(name="statutProgress", type="integer")
     */
    private $statutProgress;


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
     * Set statut
     *
     * @param string $statut
     * @return State
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set statutProgress
     *
     * @param integer $statutProgress
     * @return State
     */
    public function setStatutProgress($statutProgress)
    {
        $this->statutProgress = $statutProgress;

        return $this;
    }

    /**
     * Get statutProgress
     *
     * @return integer 
     */
    public function getStatutProgress()
    {
        return $this->statutProgress;
    }
}
