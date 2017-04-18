<?php

namespace SMS\StudyPlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TypeExamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeExamRepository extends EntityRepository
{
	/**
     * Get all Type Exam 
     *
     * @return array
     */
	public function getTypeExamAll()
	{
		return $this->createQueryBuilder('t')
				->select('t.id , t.typeExamName')
				->getQuery()
				->getResult();
	}
}
