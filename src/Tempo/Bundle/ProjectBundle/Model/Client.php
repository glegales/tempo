<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Model;

use DateTime;
/**
* @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
*/

abstract class Client implements ClientInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var integer
     */
    protected $enabled;

    /**
     * @var integer
     */
    protected $deletedAt;

    /**
     * @var integer
     */
    protected $equipe;

    /**
     * @var string
     */
    protected $contact;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var array
     */
    protected $projects;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime
     */
    protected $updated;

    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipe = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function isDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * {@inheritdoc}
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * {@inheritdoc}
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebSite()
    {
        return $this->website;
    }

    /**
     * {@inheritdoc}
     */
    public function addProject( $project)
    {
        $this->projects[] = $project;
    }

    /**
     * {@inheritdoc}
     */
    public function addUser($user)
    {
        $this->users[] = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeleteAt($deleteAt)
    {
        $this->deleteAt = $deleteAt;
        $this->setEnabled(false);
    }

    /**
     * {@inheritdoc}
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function setWebSite($website)
    {
        $this->website = $website;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function addEquipe($user)
    {
        $this->equipe[] = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getEquipe()
    {
        return $this->equipe;
    }

}
