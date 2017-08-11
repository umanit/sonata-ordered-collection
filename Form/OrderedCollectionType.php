<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Form;

use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Umanit\Bundle\SonataOrderedCollectionBundle\Model\OrderableInterface;

/**
 * Class OrderedCollectionType.
 */
class OrderedCollectionType extends CollectionType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, array(
            'collection_max_items' => $options['collection_max_items'],
            'collection_min_items' => $options['collection_min_items'],
            'collection_orderable' => $options['collection_orderable'],
        ));
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // Tri des objets pour ORM à l'envoie du formulaire
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var PersistentCollection $entity */
            $entity = $event->getData();
            $form   = $event->getForm();

            // Si le parent n'a pas encore été persisté, on a juste un tableau
            if (is_array($entity)) {
                usort($entity, function ($a, $b) {
                    if (!$a instanceof OrderableInterface) {
                        throw new InvalidArgumentException('The class must implement OrderableInterface : '.get_class($a));
                    }

                    return $a->getPosition() > $b->getPosition();
                });

                $event->setData($entity);
            } elseif ($entity instanceof PersistentCollection) {
                $data = $entity->toArray();

                usort($data, function ($a, $b) {
                    if (!$a instanceof OrderableInterface) {
                        throw new InvalidArgumentException('The class must implement OrderableInterface : '.get_class($a));
                    }

                    return $a->getPosition() > $b->getPosition();
                });

                $entity->clear();
                foreach ($data as $key => $value) {
                    $entity->set($key, $value);
                }

                $event->setData($entity);
            }
        });

        // Tri des objets pour ORM à l'envoie du formulaire
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var PersistentCollection $entity */
            $entity = $event->getData();
            $form   = $event->getForm();

            // Si le parent n'a pas encore été persisté, on a juste un tableau
            if (is_array($entity)) {
                usort($entity, function ($a, $b) {
                    if (!$a instanceof OrderableInterface) {
                        throw new InvalidArgumentException('The class must implement OrderableInterface : '.get_class($a));
                    }

                    return $a->getPosition() > $b->getPosition();
                });

                $event->setData($entity);
            } elseif ($entity instanceof PersistentCollection) {
                $data = $entity->toArray();

                usort($data, function ($a, $b) {
                    if (!$a instanceof OrderableInterface) {
                        throw new InvalidArgumentException('The class must implement OrderableInterface : '.get_class($a));
                    }

                    return $a->getPosition() > $b->getPosition();
                });

                $entity->clear();
                foreach ($data as $key => $value) {
                    $entity->set($key, $value);
                }

                $event->setData($entity);
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'collection_max_items' => null,
            'collection_min_items' => null,
            'collection_orderable' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'umanit_ordered_collection';
    }
}
