<?php

namespace SMS\EstablishmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Grade
 * @UniqueEntity(fields={"gradeName", "establishment"})
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="SMS\EstablishmentBundle\Repository\GradeRepository")
 */
class Grade
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="grade_name", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, max = 49)
     * @Assert\Regex(pattern="/^[a-z0-9 .\-]+$/i" ,match=true)
     */
    private $gradeName;

    /**
     * @var string
     *
     * @ORM\Column(name="grade_code", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, max = 49)
     * @Assert\Regex(pattern="/^[a-z0-9 .\-]+$/i" ,match=true)
     */
    private $gradeCode;

    /**
     * One Grade has Many Sections.
     * @ORM\OneToMany(targetEntity="Section", mappedBy="grade",fetch="EXTRA_LAZY")
     */
    private $sections;

    /**
     * One User has Many Grades.
     * @ORM\ManyToOne(targetEntity="SMS\UserBundle\Entity\User" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * One Grade has Many Courses.
     * @ORM\OneToMany(targetEntity="SMS\StudyPlanBundle\Entity\Course", mappedBy="grade",fetch="EXTRA_LAZY")
     */
    private $courses;

    /**
     * One establishment has Many Grades.
     * @ORM\ManyToOne(targetEntity="SMS\EstablishmentBundle\Entity\Establishment" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="establishment_id", referencedColumnName="id")
     */
    private $establishment;

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
     * Set gradeName
     *
     * @param string $gradeName
     * @return Grade
     */
    public function setGradeName($gradeName)
    {
        $this->gradeName = $gradeName;

        return $this;
    }

    /**
     * Get gradeName
     *
     * @return string
     */
    public function getGradeName()
    {
        return $this->gradeName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sections
     *
     * @param \SMS\EstablishmentBundle\Entity\Section $sections
     * @return Grade
     */
    public function addSection(\SMS\EstablishmentBundle\Entity\Section $sections)
    {
        $this->sections[] = $sections;

        return $this;
    }

    /**
     * Remove sections
     *
     * @param \SMS\EstablishmentBundle\Entity\Section $sections
     */
    public function removeSection(\SMS\EstablishmentBundle\Entity\Section $sections)
    {
        $this->sections->removeElement($sections);
    }

    /**
     * Get sections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set user
     *
     * @param \SMS\UserBundle\Entity\User $user
     * @return Grade
     */
    public function setUser(\SMS\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SMS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s",$this->getGradeName());
    }

    /**
     * Set gradeCode
     *
     * @param string $gradeCode
     *
     * @return Grade
     */
    public function setGradeCode($gradeCode)
    {
        $this->gradeCode = $gradeCode;

        return $this;
    }

    /**
     * Get gradeCode
     *
     * @return string
     */
    public function getGradeCode()
    {
        return $this->gradeCode;
    }

    /**
     * Add course
     *
     * @param \SMS\StudyPlanBundle\Entity\Course $course
     *
     * @return Grade
     */
    public function addCourse(\SMS\StudyPlanBundle\Entity\Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \SMS\StudyPlanBundle\Entity\Course $course
     */
    public function removeCourse(\SMS\StudyPlanBundle\Entity\Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set establishment
     *
     * @param \SMS\EstablishmentBundle\Entity\Establishment $establishment
     *
     * @return Grade
     */
    public function setEstablishment(\SMS\EstablishmentBundle\Entity\Establishment $establishment = null)
    {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * Get establishment
     *
     * @return \SMS\EstablishmentBundle\Entity\Establishment
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

}
