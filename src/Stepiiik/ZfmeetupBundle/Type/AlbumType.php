<?php

namespace Stepiiik\ZfmeetupBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Title'))
            ->add('Artist', null, array('label' => 'Artist'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Stepiiik\ZfmeetupBundle\Entity\Album'
        ));
    }

    public function getName()
    {
        return 'stepiiik_zfmeetupBundle_album';
    }
}
