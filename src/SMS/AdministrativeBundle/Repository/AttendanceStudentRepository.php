<?php

namespace SMS\AdministrativeBundle\Repository;

/**
 * AttendanceStudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AttendanceStudentRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get Attendance By Date and Session and User
     *
     * @param date $date
     * @param Session $session
     * @param Student $student
     * @return array
     */
    public function findByDateAndSessionAndUser($date, $session, $user)
    {
        return $this->createQueryBuilder('attendance')
                ->join('attendance.session', 'session')
                ->join('attendance.student', 'student')
                ->where("attendance.date = :date")
                ->andWhere('session.id = :session')
                ->andWhere('student.id = :student')
                ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATE)
                ->setParameter('student', $user->getId())
                ->setParameter('session', $session->getId())
                ->getQuery()
                ->getOneOrNullResult();
    }

    /**
     * Get Attendance By Date and Session and User
     *
     * @param SMS\UserBundle\Entity\Student $student
     * @param SMS\EstablishmentBundle\Entity\Division $division
     * @return array
     */
    public function findByStudent($student, $startDate , $endDate)
    {
        return $this->createQueryBuilder('attendance')
										->select("attendance.status as name, count(attendance.id) as value , student.id ,attendance.date , session.id as sessionId")
							      ->addSelect("DATE_FORMAT(attendance.date ,'%W') as day")
										->join('attendance.session', 'session')
										->join('attendance.student', 'student')
										->having('student.id = :student')
										->andHaving('attendance.date BETWEEN :startDate AND :endDate')
						   			->setParameter('startDate', $startDate->format('Y-m-d'))
						   			->setParameter('endDate', $endDate->format('Y-m-d'))
										->setParameter('student', $student->getId())
		                ->groupBy('name , day , attendance.session , student')
							      ->getQuery()
							      ->getResult();
    }

    /**
     * Get Attendance By Date and Session and User
     *
     * @param SMS\UserBundle\Entity\Student $student
     * @param SMS\EstablishmentBundle\Entity\Division $division
     * @return array
     */
    public function findStatsByStudent($student, $startDate , $endDate)
    {
        return $this->createQueryBuilder('attendance')
										->select("attendance.status as name, count(attendance.id) as value , student.id , attendance.date")
										->join('attendance.student', 'student')
										->having('student.id = :student')
										->andHaving('attendance.date BETWEEN :startDate AND :endDate')
						   			->setParameter('startDate', $startDate->format('Y-m-d'))
						   			->setParameter('endDate', $endDate->format('Y-m-d'))
										->setParameter('student', $student->getId())
		                ->groupBy('name , student')
							      ->getQuery()
							      ->getResult();
    }
}
