<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Tempo\Bundle\AppBundle\Model\Notification;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class NotificationManager extends BaseManager
{
    public function findAllByUserAndState($user, $state)
    {
        return $this->getRepository()->findAllByUserAndState($user, $state);
    }

    public function create($user, $message, $link)
    {
        $room = new Notification();
        $room->setUser($user);
        $room->setLink($link);
        $room->setMessage($message);

        $this->save($room);
    }

    public function clearForUser($user)
    {
        return $this->getRepository()->clearForUser($user);
    }
}
