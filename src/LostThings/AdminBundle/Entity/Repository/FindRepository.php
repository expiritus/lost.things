<?php

namespace LostThings\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FindRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FindRepository extends EntityRepository
{

    public function search($search){
        return $this->getEntityManager()
            ->createQuery("SELECT f FROM LostThingsAdminBundle:Find f WHERE f.thingId IN
                              (SELECT t.id FROM LostThingsAdminBundle:Thing t WHERE t.nameThing LIKE :search)
                          OR f.countryId IN
                              (SELECT k.id FROM LostThingsAdminBundle:Country k WHERE k.country LIKE :search)
                          OR f.cityId IN
                              (SELECT c.id FROM LostThingsAdminBundle:City c WHERE c.city LIKE :search)
                          OR f.areaId IN
                              (SELECT a.id FROM LostThingsAdminBundle:Area a WHERE a.area LIKE :search)
                          OR f.streetId IN
                              (SELECT s.id FROM LostThingsAdminBundle:Street s WHERE s.street LIKE :search)
                          OR f.userId IN
                              (SELECT u.id FROM LostThingsAdminBundle:User u WHERE u.username LIKE :search)
                          ORDER BY f.dateFind DESC ")
            ->setParameter('search', "%$search%")
            ->getResult();
    }

    public function findAllFindThings($ids){
        return $this->getEntityManager()
            ->createQuery('SELECT f FROM LostThingsAdminBundle:Find f WHERE f.id IN (:ids) ORDER BY f.dateFind DESC')
            ->setParameters(array('ids' => $ids))
            ->getResult();
    }


    public function findAllFindThingsArray($ids){
        return $this->getEntityManager()
            ->createQuery('SELECT f FROM LostThingsAdminBundle:Find f WHERE f.id IN (:ids) ORDER BY f.dateFind DESC')
            ->setParameters(array('ids' => $ids))
            ->getArrayResult();
    }
}
