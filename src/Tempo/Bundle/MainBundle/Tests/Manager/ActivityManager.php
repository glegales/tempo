<?php

namespace Tempo\Bundle\MainBundle\Tests\Manager;

class ActivityManagerTest extends \PHPUnit_Framework_TestCases
{
    private function createActivityManager()
    {
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $class = '';

        $manager =  $this->getMockBuilder('Tempo\Bundle\MainBundle\Manager\ActivityManager')
            ->disableOriginalConstructor()
            ->getMock();

        return new ActivityManager(
            $dispatcher, $objectManager, $class
        );
    }
}