<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\StateRepository")
 */
class State {

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
     * @var \Project
     * @ORM\OneToMany(targetEntity="Project", mappedBy="state")
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct() {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set statut
     *
     * @param string $statut
     * @return State
     */
    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Add projects
     *
     * @param \Imie\SkillsBundle\Entity\Project $projects
     * @return State
     */
    public function addProject(\Imie\SkillsBundle\Entity\Project $projects) {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Imie\SkillsBundle\Entity\Project $projects
     */
    public function removeProject(\Imie\SkillsBundle\Entity\Project $projects) {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects() {
        return $this->projects;
    }

}
