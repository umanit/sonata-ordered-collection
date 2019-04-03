<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Symfony\Component\Form\CallbackTransformer;

/**
 * Trait OrderableTypeTrait
 * @package Umanit\Bundle\SonataOrderedCollectionBundle\Model
 */
trait OrderableTypeTrait
{
	/**
	 * Returns current ordered element
	 */
	public function getCurrentElement(){
		global $index, $request;
		$index++;
		$ownerClass = $this->getOwnerClass();
		$attributes = $request->attributes;
		$currentItem = null;
		if(!empty($attributes)) {
			$subject = $this->modelManager->find( $ownerClass, $attributes->get( 'id' ) );

			if ( ! empty( $subject ) ) {
				try {
					$teasers      = $subject->getOrderableCollection()->getValues();
					$subjectId    = $subject->getId();
					$subjectClass = get_class( $subject );
					$currentIndex = $index;
					$currentItem  = array_filter( $teasers, function ( $item ) use ( $subjectClass, $subjectId, $currentIndex ) {
						return $item->getEntityPosition( $subjectClass, $subjectId ) == (string) $currentIndex;
					} );

					$currentItem = array_shift( $currentItem );
				} catch ( \Exception $e ) {

				}
			}

		}

		return $currentItem;
	}

	/**
	 * Returns field description
	 * @return FieldDescription
	 */
	public function getFieldDescription(){
		$fieldDescription = new FieldDescription();
		$fieldDescription->setAssociationAdmin($this->getOwnerAdmin());
		$fieldDescription->setAdmin($this->getOrderableItemAdmin());
		$fieldDescription->setOptions(array(
			'link_parameters' => array(
				'context' => 'default'
			)
		));

		return $fieldDescription;
	}

	/**
	 * Transform current orderable item for saving
	 * @param $builder
	 * @param $currentItem
	 */
	public function addFormElementTransformer($builder, $currentItem){
		try {
			$builder->get( 'id' )->addModelTransformer(
				new CallbackTransformer(
					function ( $item ) use ($currentItem){
						return $currentItem;
					}, function ( $item ) {

					return (!empty($item)) ? $item->getId() : false;
				}
				)
			);
		}catch (\Exception $e){

		}
	}

	/**
	 * Initializes index for orderable list
	 */
	public function initIndex(){
		global $index;
		$index = -1;
	}

}
