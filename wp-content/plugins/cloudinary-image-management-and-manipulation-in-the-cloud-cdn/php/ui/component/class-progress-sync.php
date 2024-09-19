<?php
/**
 * Ring Component.
 *
 * @package Cloudinary
 */

namespace Cloudinary\UI\Component;

use Cloudinary\REST_API;

/**
 * Ring Component to render components only.
 *
 * @package Cloudinary\UI
 */
class Progress_Sync extends Progress_Ring {

	/**
	 * Holds the components build blueprint.
	 *
	 * @var string
	 */
	protected $blueprint = 'wrap/';

	/**
	 * Gets the wrap structs.
	 *
	 * @param array $struct The wrap struct.
	 *
	 * @return array
	 */
	protected function wrap( $struct ) {
		$struct = parent::wrap( $struct );
		if ( true === $this->setting->get_param( 'poll' ) ) {
			$struct['attributes']['data-url']  = rest_url( REST_API::BASE . '/stats' );
			$struct['attributes']['data-poll'] = true;
		}

		return $struct;
	}
}
