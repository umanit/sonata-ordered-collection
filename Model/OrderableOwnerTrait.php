<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait OrderableOwnerTrait
 * @package Umanit\Bundle\SonataOrderedCollectionBundle\Model
 */
trait OrderableOwnerTrait
{

	/**
	 * Returns sorted collection by given owning class and id
	 *
	 * @param int $id Owning entity id
	 * @param array $collection Collection to be sorted
	 *
	 * @return array
	 */
	public function getSortedCollection(int $id, array $collection){
		$sorted = array();
		foreach ($collection as $index => $item){
			$position = $item->getEntityPosition(self::class, $id);
			$sorted[$position] = $item;
		}
		ksort($sorted);
		$sorted = array_values($sorted);

		return $sorted;
	}
}
