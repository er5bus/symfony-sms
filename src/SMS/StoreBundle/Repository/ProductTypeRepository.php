<?php

namespace SMS\StoreBundle\Repository;

/**
 * ProductTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductTypeRepository extends \Doctrine\ORM\EntityRepository
{
  /**
     * Get Grade By Establishment
     *
     * @param Establishment $establishment
     * @return array
     */
	public function findByEstablishment($establishment)
	{
		return $this->createQueryBuilder('productType')
				->join('productType.establishment', 'establishment')
				->andWhere('establishment.id = :establishment')
				->setParameter('establishment', $establishment->getId())
				->getQuery()
				->getResult();
	}
}