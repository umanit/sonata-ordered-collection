<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

/**
 * Interface OrderableTypeInterface
 * @package Umanit\Bundle\SonataOrderedCollectionBundle\Model
 */
interface OrderableTypeInterface
{
	/**
	 * Retuerns orderable collection owner class name
	 * @return string
	 */
    public function getOwnerClass();

	/**
	 * Retuerns orderable element class name
	 * @return string
	 */
	public function getOrderableElementClass();

	/**
	 * Returns orderable collection owner admin instance
	 * @return mixed
	 */
    public function getOwnerAdmin();

	/**
	 * Returns orderable item admin instance
	 * @return mixed
	 */
	public function getOrderableItemAdmin();

	/**
	 * Returns orderable item form element id
	 * @return mixed
	 */
	public function getOrderableFormChildId();
}
