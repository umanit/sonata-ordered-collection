## Purpose

The bundle is an extension of the sonata "collection type" in order to be able to order elements in the collection

## Requirements

It only works in Sonata admin.

## Configuration

Register the bundle to your `app/AppKernel.php`

```php
<?php

    new Umanit\Bundle\SonataOrderedCollection\UmanitSonataOrderedCollectionBundle(),
```

Add the form theme to twig
```yaml
twig:
    form_themes:
        - 'UmanitSonataOrderedCollectionBundle:Form:form_sonata_ordered_collection.html.twig'
```

Add the CSS/JS (after `bin/console assets:install`)
```yaml
sonata_admin:
    assets:
        stylesheets:
            # Put defaults sonata stylesheets here
            # ...
            - bundles/umanitsonataorderedcollection/css/ordered-collection.css
        javascripts:
            # Put defaults sonata stylesheets here
            # ...
            - bundles/umanitsonataorderedcollection/js/ordered-collection.js
```

That's all ! easy isn't it ?

## Usage

Create an entity that implements `OrderableInterface` (you can use the `OrderableTrait` if you want to save time). Use OrderableOwnerTrait in OderableInterface ownling class.

```php
<?php

use Umanit\SonataOrderedCollectionBundle\Model\OrderableInterface;
use Umanit\Bundle\SonataOrderedCollectionBundle\Model\OrderableTrait;

class Answer implements OrderableInterface
{
    use OrderableTrait;

    // ...
}
```

Create the associated form that will be repeated, with a field "hidden" and the "umanit-sortable-order" CSS class. Add ```$this->initIndex();``` to ``MyClassType`` constructor.

```php
<?php

class MyClassType extends AbstractType, implements OrderableTypeInterface
{
	use OrderableTypeTrait;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', HiddenType::class, ['attr' => ['class' => 'umanit-sortable-order']])
            // ....
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\MyClass',
        ]);
    }
}
```

You can also extends the `OrderableFormType` if you don't want to declare that field

```php
<?php

use Umanit\Bundle\SonataOrderedCollectionBundle\Form\OrderableFormType;

class MyClassType extends OrderableFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\CartridgeColor',
        ]);
    }
}
```

In your admin use OrderableOwnerAdminTrait and call it like that :
```php
<?php

->with('Class')
    ->add('myclasses', OrderedCollectionType::class, [
        'label' => false,
        'cascade_validation' => true,
        'entry_type'  => MyClassType::class,
        'allow_add' => true,
        'allow_delete' => true,
        'entry_options' => [
            'label' => false
        ]
    ])
->end()
```

Nows, to get the elements in the right order, add the orderBy annotation on the right attribute
```
 @ORM\OrderBy({"position" = "ASC"})
```

## Repeat a sonata field

If you need to repeat a sonata field, you need to add some configuration (e.g for `sonata_media` field)

```php
<?php

class MyClassType extends OrderableFormType
{
    /**
     * @var MediaAdmin
     */
    protected $mediaAdmin;

    /**
     * @param MediaAdmin $mediaAdmin
     */
    public function __construct(MediaAdmin $mediaAdmin)
    {
        $this->mediaAdmin  = $mediaAdmin;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $fieldDescriptionMedia = new FieldDescription();
        $fieldDescriptionMedia->setAssociationAdmin($this->mediaAdmin);
        $fieldDescriptionMedia->setAdmin($options['admin_instance']);
        $fieldDescriptionMedia->setOptions(array(
            'link_parameters' => array(
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default'
            )
        ));

        $builder
            ->add('image', 'sonata_type_model_list', [
                'label' => 'Image',
                'model_manager' => $options['model_manager'],
                'class' => 'Application\Sonata\MediaBundle\Entity\Media',
                'sonata_field_description' => $fieldDescriptionMedia,
                'btn_list' => false
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'     => 'AppBundle\Entity\MyClass',
            'model_manager'  => null,
            'admin_instance' => null,
        ));
    }
}
```

In your admin, call it like that :
```php
<?php

->with('Class')
    ->add('myclasses', OrderedCollectionType::class, [
        'label' => false,
        'cascade_validation' => true,
        'entry_type'  => MyClassType::class,
        'allow_add' => true,
        'allow_delete' => true,
        'entry_options' => [
            'label'           => false,
            'model_manager'   => $this->getModelManager(),
            'admin_instance'  => $this
        ]
    ])
->end()
```
