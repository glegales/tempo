<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tempo\Bundle\ProjectBundle\Repository\OrganizationRepository;
use Tempo\Bundle\ProjectBundle\Repository\ProjectTypeRepository;
use Tempo\Bundle\ProjectBundle\Entity\Project;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'tempo.project.form.label.name',
            ))
            ->add('description', 'ckeditor', array(
                'required' => false,
                'label'    => 'tempo.project.form.label.isactive',
                'config_name' => 'default',
            ))
            ->add('active', null, array(
                'label' => 'tempo.project.form.label.isactive'
            ))
            ->add('beginning', 'datetimepicker', array(
                'label' => 'tempo.project.form.label.beginning',
            ))
            ->add('ending', 'datetimepicker', array(
                'label' => 'tempo.project.form.label.ending',
            ))
            ->add('type', null, array(
                'label' => 'tempo.project.form.label.type',
                'class' => 'TempoProjectBundle:ProjectType',
                'query_builder' => function(ProjectTypeRepository $er) {
                    return $er->findAllTypes();
                }
            ))
            ->add('advancement', null, array(
                'label' => 'tempo.project.form.label.advancement',
                'attr' => array(
                    'disabled' => 'disabled',
                    'style' => 'display: none'
                )
            ))
            ->add('code', null, array(
                'label' => 'tempo.project.form.label.code'
            ))
            ->add('budget_estimated', null, array(
                'label' => 'tempo.project.form.label.estimated'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'user_id' => null,
            'data_class' => 'Tempo\Bundle\ProjectBundle\Entity\Project',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'project';
    }
}
