<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
			$teaserId = $itemTmp->getId();
			$teaser = $repository->find($teaserId);
			if(!empty($teaser)) {
				$position = $itemTmp->getPosition();
				$positionsData = $teaser->getPositions();
				$positions = json_decode($positionsData);
				if(empty($positions)){
					$positions = new \stdClass();
				}
				if(empty($positions->{$objectClass})){
					$positions->{$objectClass} = new \stdClass();
				}
				$positions->{$objectClass}->{$objectId} = $position;
				$json = json_encode($positions);
				$teaser->setPositions($json);
				$collection->add( $teaser );
			}
		}
		$object->setOrderableCollection($collection);
		return parent::update($object);
	}
}
