<?php

namespace Tempo\Bundle\ActivityBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ActivityProviderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActivityProviderRepository extends EntityRepository
{
    public function getAllTrelloBoard()
    {
        $query = $this->createQueryBuilder('ap');
        $query->where('ap.provider = :provider');
        $query->setParameter('provider', 'Trello');

        return $query->getQuery()->getResult();
    }
}