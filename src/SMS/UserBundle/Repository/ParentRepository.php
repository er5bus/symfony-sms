<?php

namespace SMS\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SMS\UserBundle\Entity\User;
/**
 * ParentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ParentRepository extends EntityRepository
{
	/**
     * @param string[] $criteria format: array('user' => <user_id>, 'name' => <name>)
     */
    public function findByUniqueCriteria(array $criteria)
    {
        // would use findOneBy() but Symfony expects a Countable object
        return $this->_em->getRepository(User::class)->findBy($criteria);
    }
}
