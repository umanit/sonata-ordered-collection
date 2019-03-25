<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait OrderableTrait
 * @package Umanit\Bundle\SonataOrderedCollectionBundle\Model
 */
trait OrderableTrait
{
	/**
	 * Current save position
	 * @var int
	 *
	 * @ORM\Column(name="position", type="integer", nullable=true)
	 */
	protected $position;
	/**
	 * @var string
	 * @ORM\Column(name="positions", type="string", nullable=true)
	 */
	protected $positions;

	/**
	 * Sets the position of the element in a collection.
	 *
	 * @param int $position
	 */
	public function setPosition($position)
	{
		$this->position = $position;
	}

	/**
	 * Returns the position of the element in a collection.
	 *
	 * @return int
	 */
	public function getPosition()
	{
		return $this->position;
	}


	/**
	 * Sets multiple positions
	 * @return string
	 */
	public function getPositions() {
		return $this->positions;
	}

	/**
	 * Returns multiple positions
	 *
	 * @param string $positions
	 */
	public function setPositions( string $positions ) {
		$this->positions = $positions;
	}

	/**
	 * Returns position in given entity
	 * @param $id
	 *
	 * @return int
	 */
	public function getEntityPosition($class, $id){
		$result = 0;
		$json = $this->getPositions();
		$positions = json_decode($json);
		try {
			$position = $positions->{$class}->{$id};
		}catch (\Exception $e){

		}
		if(!empty($position)){
			$result = $position;
		}

		return $result;

	}

}
