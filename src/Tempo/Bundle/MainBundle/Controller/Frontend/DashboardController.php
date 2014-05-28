<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\CoreBundle\Controller\BaseController;
use Tempo\Bundle\MainBundle\Form\Type\ChatMessageType;

class DashboardController extends BaseController
{
    /**
     * main Action
     * 
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(Request $request)
    {
        $manager = $this->getManager('room');

        $rooms = $manager->findAll();
        $roomId = $request->query->get('currentRoom', $rooms[0]->getId());

        $request->getSession()->set('currentRoom', $roomId);
        $currentRoom = $this->getManager('room')->find( $request->getSession()->get('currentRoom'));

        $form  = $this->createForm(new ChatMessageType());

        return $this->render('TempoMainBundle:Default:dashboard.html.twig', array(
            'rooms' => $rooms,
            'currentRoom' => $currentRoom,
            'form' => $form->createView()
        ));
    }
}
