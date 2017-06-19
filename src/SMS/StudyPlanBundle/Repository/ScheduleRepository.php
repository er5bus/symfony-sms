<?php

namespace SMS\StudyPlanBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SMS\StudyPlanBundle\Entity\Session;

/**
 * Schedule Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends EntityRepository
{
    /**
     * Get Schedule By Section And By Day And By Session And By Division
     *
     * @param SMS\EstablishmentBundle\Entity\Exam $section
     * @param SMS\EstablishmentBundle\Entity\Division $division
     * @return array
     */
    public function findBySectionAndDivisionAndEstablishment($section, $division ,$establishment)
    {
        return $this->createQueryBuilder('schedule')
                ->select("section.id as sectionID , section.sectionName as sectionName ,schedule.day, course.id as courseID ,course.courseName as courseName , establishment.id, course.coefficient as coefficient , CONCAT(professor.firstName , professor.lastName) as name ,section.id, division.id ")
                ->addSelect(sprintf("(SELECT GROUP_CONCAT(session.id SEPARATOR ', ' ) FROM %s as session  WHERE session MEMBER OF schedule.sessions ) AS sessionIDS", Session::class))
                ->join('schedule.section', 'section')
                ->join('schedule.professor', 'professor')
                ->join('schedule.course', 'course')
                ->join('schedule.establishment', 'establishment')
                ->join('course.division', 'division')
                ->having('section.id = :section')
      					->andHaving('establishment.id = :establishment')
      					->setParameter('establishment', $establishment->getId())
                ->andHaving('division.id = :division')
                ->groupBy('schedule.day , courseID ,  sessionIDS')
                ->setParameter('section', $section->getId())
                ->setParameter('division', $division->getId())
                ->getQuery()
                ->getResult();
    }

    /**
     * Get Schedule By Professor And By Division
     *
     * @param SMS\UserBundle\Entity\Exam $professor
     * @param SMS\EstablishmentBundle\Entity\Division $division
     * @return array
     */
    public function findByProfessor($professor, $division, $establishment)
    {
        return $this->createQueryBuilder('schedule')
                ->select("section.id as sectionID , section.sectionName as sectionName , schedule.day ,course.courseName as courseName , course.coefficient as coefficient ,establishment.id , CONCAT(professor.firstName , professor.lastName) as name ,course.id as courseID,professor.id, division.id ")
                ->addSelect(sprintf("(SELECT GROUP_CONCAT(session.id SEPARATOR ', ' ) FROM %s as session  WHERE session MEMBER OF schedule.sessions ) AS sessionIDS", Session::class))
                ->join('schedule.professor', 'professor')
                ->join('schedule.course', 'course')
                ->join('schedule.section', 'section')
                ->join('schedule.establishment', 'establishment')
                ->join('course.division', 'division')
                ->having('professor.id = :professor')
                ->andHaving('division.id = :division')
                ->andHaving('establishment.id = :establishment')
      					->setParameter('establishment', $establishment)
                ->groupBy('schedule.day , schedule.course ,  sessionIDS')
                ->setParameter('professor', $professor->getId())
                ->setParameter('division', $division->getId())
                ->getQuery()
                ->getResult();
    }
}
