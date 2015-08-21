<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\CourseRepository")
 */
class Course
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
     * @ORM\Column(name="courseName", type="string", length=255)
     */
    private $courseName;
    /**
     *  @ORM\ManyToOne(targetEntity="Promo", inversedBy="course")
     */
    private $promo;
    /**
     * @ORM\OneToMany(targetEntity="School", mappedBy="course")
     */
    private $school;


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
     * Set courseName
     *
     * @param string $courseName
     * @return course
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;

        return $this;
    }

    /**
     * Get courseName
     *
     * @return string 
     */
    public function getCourseName()
    {
        return $this->courseName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->school = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set promo
     *
     * @param \Imie\SkillsBundle\Entity\Promo $promo
     * @return Course
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
     * Add school
     *
     * @param \Imie\SkillsBundle\Entity\School $school
     * @return Course
     */
    public function addSchool(\Imie\SkillsBundle\Entity\School $school)
    {
        $this->school[] = $school;

        return $this;
    }

    /**
     * Remove school
     *
     * @param \Imie\SkillsBundle\Entity\School $school
     */
    public function removeSchool(\Imie\SkillsBundle\Entity\School $school)
    {
        $this->school->removeElement($school);
    }

    /**
     * Get school
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchool()
    {
        return $this->school;
    }
}
