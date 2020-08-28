<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface OrderableOwnerInterface
 * @package Umanit\Bundle\SonataOrderedCollectionBundle\Model
 */
interface OrderableOwnerInterface
{
	/**
	 * Sets sorted collection
	 * @param ArrayCollection $collection
	 *
	 * @return mixed
	 */
    public function setOrderableCollection(ArrayCollection $collection);

	/**
	 * Returns Ordered collection
	 * @return mixed
	 */
    public function getOrderableCollection();

	/**
	 * Returns orderable item repository
	 * @return mixed
	 */
    public function getOrderableItemRepository();
}
