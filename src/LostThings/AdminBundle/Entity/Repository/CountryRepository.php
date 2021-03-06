<?php

namespace LostThings\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CountryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CountryRepository extends EntityRepository
{
    public function search($search){
        return $this->getEntityManager()
            ->createQuery("SELECT a FROM LostThingsAdminBundle:Country a WHERE a.country LIKE :search ")
            ->setParameter('search', "%$search%")
            ->getResult();
    }


    public function findAll()
    {
        return $this->findBy(array(), array('country' => 'asc'));
    }
}
