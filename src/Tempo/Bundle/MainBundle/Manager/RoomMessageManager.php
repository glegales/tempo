<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Manager;

use Tempo\Bundle\MainBundle\Entity\Room;
use Tempo\Bundle\CoreBundle\Manager\BaseManager;

/**
 *
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class RoomMessageManager extends BaseManager
{

    public function all($room , $limit, $offset, $orderby )
    {
        return $this->repository->findBy(array('room' => $room), $orderby, $limit, $offset);
    }
}