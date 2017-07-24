<?php

namespace SMS\StudyPlanBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SMS\StudyPlanBundle\Entity\Session;

/**
 * ExamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExamRepository extends EntityRepository
{
		/**
		 * Get exam By Section And By Day And By Session And By Division
		 *
		 * @param SMS\EstablishmentBundle\Entity\Exam $section
		 * @param SMS\EstablishmentBundle\Entity\Division $division
		 * @return array
		 */
		public function findBySectionAndDivisionAndEstablishment($section, $division ,$establishment)
		{
				return $this->createQueryBuilder('exam')
								->select("exam.id as examID , exam.examName , exam.dateExam ,exam.startTime , exam.endTime , course.id as courseID , typeExam.id as typeExamID  , establishment.id ,section.id, division.id ")
								->join('exam.section', 'section')
								->join('exam.course', 'course')
								->join('exam.typeExam', 'typeExam')
								->join('exam.establishment', 'establishment')
								->join('course.division', 'division')
								->where('section.id = :section')
								->andWhere('establishment.id = :establishment')
								->andWhere('division.id = :division')
								->groupBy('courseID ,  typeExamID')
								->setParameter('establishment', $establishment->getId())
								->setParameter('section', $section->getId())
								->setParameter('division', $division->getId())
								->getQuery()
								->getResult();
		}
	/**
     * Get Exam By Course
     *
     * @param integer $course
		 * @param integer $section
     * @return array
     */
	public function findByCourseAndSection($course , $section)
	{
		return $this->createQueryBuilder('exam')
				->join('exam.course', 'course')
				->join('exam.section', 'sections')
				->where("sections.id = :section")
				->andWhere('course.id = :course')
				->setParameter('course', $course)
				->setParameter('section', $section)
				->getQuery()
				->getResult();
	}
	/**
     * Get Exam By StartDate And EndDate
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
	public function findByStartDateAndEndDateBySection($startDate , $endDate, $section)
	{
		return $this->createQueryBuilder('exam')
				->select("exam.examName as title ,course.coefficient, course.courseName, typeExam.typeExamName  , DATE_FORMAT(exam.startTime ,'%H:%m') as startTime , DATE_FORMAT(exam.endTime ,'%H:%m') as endTime")
				->addSelect("DATE_FORMAT(exam.dateExam ,'%Y-%m-%d') as date")
				->join('exam.course', 'course')
				->join('exam.typeExam', 'typeExam')
				->where('exam.dateExam BETWEEN :startDate AND :endDate')
				->andWhere(':section MEMBER OF exam.section')
				->setParameter('section',  $section)
   			->setParameter('startDate', $startDate->format('Y-m-d'))
   			->setParameter('endDate', $endDate->format('Y-m-d'))
				->getQuery()
				->getResult();
	}

	/**
     * Get Exam By StartDate And EndDate
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
	public function findByStartDateAndEndDateByStudents($startDate , $endDate, $student)
	{
		return $this->createQueryBuilder('exam')
				->distinct()
				->select("exam.examName as title ,course.coefficient, course.courseName, typeExam.typeExamName  , DATE_FORMAT(exam.startTime ,'%H:%m') as startTime , DATE_FORMAT(exam.endTime ,'%H:%m') as endTime")
				->addSelect("DATE_FORMAT(exam.dateExam ,'%Y-%m-%d') as date")
				->join('exam.course', 'course')
				->join('exam.section', 'section')
				->join('section.students', 'student')
				->join('exam.typeExam', 'typeExam')
				->where('exam.dateExam BETWEEN :startDate AND :endDate')
				->andWhere('student IN (:student)')
				->setParameter('student',  $student)
   			->setParameter('startDate', $startDate->format('Y-m-d'))
   			->setParameter('endDate', $endDate->format('Y-m-d'))
				->getQuery()
				->getResult();
	}
}
