<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Type\Backend\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * User filter form type.
 */
class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'tempo.user.list.filter.query',
                'attr'  => array(
                    'placeholder' => 'tempo.user.list.filter.query'
                )
            ))
        ;
    }

    public function getName()
    {
        return 'tempo_user_filter';
    }
}
