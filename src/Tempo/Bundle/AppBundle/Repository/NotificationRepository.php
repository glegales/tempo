<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * NotificationRepository
 */
class NotificationRepository extends EntityRepository
{
    /**
     * @param $user
     * @param $state
     */
    public function findAllByUserAndState($user, $state)
    {
        $q = $this->createQueryBuilder('notif')
            ->leftJoin('notif.user', 'user')
            ->where('user = :user')
            ->andWhere('notif.state = :state')
            ->setParameters(array(
                'state'  => $state,
                'user'   => $user
            ))
            ->getQuery();

        return $q;
    }

    /**
     * @param $user
     */
    public function clearForUser($user)
    {
        $q = $this->createQueryBuilder('notif')
            ->update('TempoAppBundle:Notification', 'notif')
            ->set('notif.state', 1)
            ->where('notif.user = :user')
            ->setParameter('user', $user)
            ->getQuery();
        $p = $q->execute();
    }
}
