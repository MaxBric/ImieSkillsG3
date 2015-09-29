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
     * @ORM\Column(name="course", type="string", length=255)
     */
    private $course;
    /**
     * @ORM\OneToMany(targetEntity="Promo", mappedBy="course", cascade={"remove"})
     */
    private $promos;
    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="courses")
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="courseFullName", type="string", length=255)
     *
     */
    private $courseFullName;

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
     * Add school
     *
     * @param \Imie\SkillsBundle\Entity\School $school
     * @return Course
     */

    /**
     * Set school
     *
     * @param \Imie\SkillsBundle\Entity\School $school
     * @return Course
     */
    public function setSchool(\Imie\SkillsBundle\Entity\School $school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \Imie\SkillsBundle\Entity\School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set course
     *
     * @param string $course
     * @return Course
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->promos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add promos
     *
     * @param \Imie\SkillsBundle\Entity\Promo $promos
     * @return Course
     */
    public function addPromo(\Imie\SkillsBundle\Entity\Promo $promos)
    {
        $this->promos[] = $promos;

        return $this;
    }

    /**
     * Remove promos
     *
     * @param \Imie\SkillsBundle\Entity\Promo $promos
     */
    public function removePromo(\Imie\SkillsBundle\Entity\Promo $promos)
    {
        $this->promos->removeElement($promos);
    }

    /**
     * Get promos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPromos()
    {
        return $this->promos;
    }
    

    /**
     * Set courseFullName
     *
     * @param string $courseFullName
     * @return Course
     */
    public function setCourseFullName()
    {
        $this->courseFullName = $this->school->getSchoolName().' - '.$this->getCourse();

        return $this;
    }

    /**
     * Get courseFullName
     *
     * @return string 
     */
    public function getCourseFullName()
    {
        return $this->courseFullName;
    }
}
