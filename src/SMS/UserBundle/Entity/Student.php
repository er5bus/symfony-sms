<?php

namespace SMS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Student
 * @Vich\Uploadable
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="SMS\UserBundle\Repository\StudentRepository")
 */
class Student extends User
{
    /**
     * @var string
     *
     * @ORM\Column(name="recordeNumber", type="string", length=150, unique=true , nullable=true)
     */
    private $recordeNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50)
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"}),
     * @Assert\Regex(pattern="/^[a-z0-9 .\-]+$/i" ,match=true , groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     * @Assert\Length(min = 2, max = 40 , groups= {"Registration" , "Intern" ,"InternRegistration"  ,"SimpleRegistration" , "Edit","InternEdit"})
     */
    private $firstName;

    /**
     * @var bool
     *
     * @ORM\Column(name="studentType", type="boolean")
     */
    private $studentType;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50)
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     * @Assert\Regex(pattern="/^[a-z0-9 .\-]+$/i" ,match=true , groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     * @Assert\Length(min = 2, max = 40 , groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=30)
     * @Assert\Choice(choices = {"gender.male", "gender.female", "gender.other"} , groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date")
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     * @Assert\Date(groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"})
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20)
     * @Assert\Regex( pattern="/\d/", groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"}),
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"}),
     * @Assert\Length(
     *    min = 8,
     *    max = 20,
     *    groups= {"Registration" , "Intern" ,"InternRegistration"  , "SimpleRegistration" , "Edit","InternEdit"}
     * )
     */
    private $phone;

    /**
     * Many Students have One Section.
     * @ORM\ManyToOne(targetEntity="SMS\EstablishmentBundle\Entity\Section", inversedBy="students" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration","InternEdit" })
     */
    private $section;

    /**
     * Many Students have One Parent.
     * @ORM\ManyToOne(targetEntity="StudentParent" , inversedBy="students",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="student_parent_id", referencedColumnName="id")
     * @Assert\NotBlank(groups= {"Registration" , "Intern" ,"InternRegistration" ,"InternEdit"})
     */
    private $studentParent;

    /**
     * Many Students have Many registrations.
     * @ORM\ManyToMany(targetEntity="SMS\PaymentBundle\Entity\PaymentType", mappedBy="student",fetch="EXTRA_LAZY")
     */
     private $registrations;

     /**
      * User constructor.
      */
     public function __construct()
     {
         parent::__construct();
         $this->roles = array(self::ROLE_STUDENT);
         $this->registrations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set recordeNumber
     *
     * @param string $recordeNumber
     * @return Student
     */
    public function setRecordeNumber($recordeNumber)
    {
        $this->recordeNumber = $recordeNumber;

        return $this;
    }

    /**
     * Get recordeNumber
     *
     * @return string
     */
    public function getRecordeNumber()
    {
        return $this->recordeNumber;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Student
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Student
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set section
     *
     * @param \SMS\EstablishmentBundle\Entity\Section $section
     * @return Student
     */
    public function setSection(\SMS\EstablishmentBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \SMS\EstablishmentBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set studentParent
     *
     * @param \SMS\UserBundle\Entity\StudentParent $studentParent
     * @return Student
     */
    public function setStudentParent(\SMS\UserBundle\Entity\StudentParent $studentParent = null)
    {
        $this->studentParent = $studentParent;

        return $this;
    }

    /**
     * Get studentParent
     *
     * @return \SMS\UserBundle\Entity\StudentParent
     */
    public function getStudentParent()
    {
        return $this->studentParent;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Student
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Student
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set studentType
     *
     * @param boolean $studentType
     *
     * @return Student
     */
    public function setStudentType($studentType)
    {
        $this->studentType = $studentType;

        return $this;
    }

    /**
     * Get studentType
     *
     * @return boolean
     */
    public function getStudentType()
    {
        return $this->studentType;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Student
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add registration
     *
     * @param \SMS\PaymentBundle\Entity\PaymentType $registration
     *
     * @return Student
     */
    public function addRegistration(\SMS\PaymentBundle\Entity\PaymentType $registration)
    {
        $this->registrations[] = $registration;

        return $this;
    }

    /**
     * Remove registration
     *
     * @param \SMS\PaymentBundle\Entity\PaymentType $registration
     */
    public function removeRegistration(\SMS\PaymentBundle\Entity\PaymentType $registration)
    {
        $this->registrations->removeElement($registration);
    }

    /**
     * Get registrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s %s",$this->getFirstName(),$this->getLastName());
    }
}
