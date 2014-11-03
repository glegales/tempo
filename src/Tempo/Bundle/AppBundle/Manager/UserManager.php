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

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Tempo\Bundle\AppBundle\Model\UserInterface;


/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class UserManager extends BaseManager
{
    protected $encoderFactory;

    public function setEncoder(EncoderFactoryInterface $encoder)
    {
        return $this->encoderFactory = $encoder;
    }

    public function getEncoder($user)
    {
        return $this->encoderFactory->getEncoder($user);
    }

    /**
     * {@inheritDoc}
     */
    public function updatePassword(UserInterface $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }

        return $user;
    }

    /**
     * Finds a user by email
     *
     * @param string $email
     *
     * @return UserInterface
     */
    public function findUserByEmail($email)
    {
        return $this->findUserBy(array('emailCanonical' => $email));
    }

    /**
     * Finds a user by username
     *
     * @param string $username
     *
     * @return UserInterface
     */
    public function findUserByUsername($username)
    {
        return $this->findUserBy(array('slug' => $username));
    }

    /**
     * Finds a user either by email, or username
     *
     * @param string $usernameOrEmail
     *
     * @return UserInterface
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }
        return $this->findUserByUsername($usernameOrEmail);
    }

    public function findUserByConfirmationToken($criteria)
    {
        return $this->findUserBy(array('confirmationToken' => $criteria));
    }

    public function findUserBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    public function totalUsers()
    {
        return $this->getRepository()->totalUsers();
    }

    public function save($user, $flush = true)
    {
        $user = $this->updatePassword($user);
        return parent::save($user, $flush);
    }
}