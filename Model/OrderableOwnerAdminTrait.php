<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait OrderableOwnerAdminTrait
 * @package Umanit\Bundle\SonataOrderedCollectionBundle\Model
 */
trait OrderableOwnerAdminTrait
{

	/**
	 * Update ordered collection
	 */
	public function update( $object ) {
		$items = $object->getOrderableCollection();
		$collection = new ArrayCollection();
		$repository = $object->getOrderableItemRepository();
		$objectId = $object->getId();
		$objectClass = get_class($object);
		foreach ($items as $itemTmp){
			$itemId = $itemTmp->getId();
			$item = $repository->find($itemId);
			if(!empty($item)) {
				$position = $itemTmp->getPosition();
				$positionsData = $item->getPositions();
				$positions = json_decode($positionsData);
				if(empty($positions)){
					$positions = new \stdClass();
				}
				if(empty($positions->{$objectClass})){
					$positions->{$objectClass} = new \stdClass();
				}
				$positions->{$objectClass}->{$objectId} = $position;
				$json = json_encode($positions);
				$item->setPosition($position);
				$item->setPositions($json);
				$collection->add( $item );
			}
		}
		$object->setOrderableCollection($collection);
		return parent::update($object);
	}
}
