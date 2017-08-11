<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class OrderableFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', HiddenType::class, ['attr' => ['class' => 'umanit-sortable-order']])
        ;
    }
}
