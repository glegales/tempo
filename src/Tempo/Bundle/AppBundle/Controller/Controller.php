<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\ORM\Query;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class Controller extends FOSRestController
{
    protected static $_flashTypes = array('normal', 'success', 'warning', 'danger');

    protected function addFlash($type, $message, $domaine = null)
    {
        if (!in_array($type, self::$_flashTypes)) {
            throw new \Exception(sprintf(
                'Available values: %s',
                implode(', ', self::$_flashTypes)
            ));
        }

        $this->get('session')->getFlashBag()->add($type, $this->getTranslation($message, array(), $domaine));
    }

    /**
     * @param string $key
     * @param string $token
     * @return bool
     * @throws AccessDeniedException
     */
    protected function tokenIsValid($key, $token)
    {
        //check token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid($key, $token)) {
            throw new AccessDeniedException('Invalid token.');
        }

        return true;
    }

    /**
     * @param $message
     * @param array $parameter
     * @param null $domaine
     * @return string
     */
    protected function getTranslation($message, $parameter = array(), $domaine = null)
    {
        return $this->get('translator')->trans($message, $parameter, $domaine);
    }

    /**
     * @param string $name
     * @return \Tempo\Bundle\AppBundle\Manager\BaseManager
     */
    protected function getManager($name)
    {
        return $this->get('tempo.manager.'. $name);
    }

    /**
     * @return \Problematic\AclManagerBundle\Domain\AclManager
     */
    protected function getAclManager()
    {
        return $this->get('problematic.acl_manager');
    }

    /**
     * Returns the paginator instance configured for the given query and page
     * number
     *
     * @param  Query   $query The query
     * @param  integer $page  The current page number
     * @param  integer $limit Results per page
     *
     * @return Pagerfanta
     */
    protected function getPaginator(Query $query, $page, $limit = 10)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator
            ->setMaxPerPage($limit)
            ->setCurrentPage($page, false, true)
        ;

        return $paginator;
    }
}
