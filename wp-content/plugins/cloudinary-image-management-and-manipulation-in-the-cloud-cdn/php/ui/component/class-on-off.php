<?php
/**
 * On off UI Component.
 *
 * @package Cloudinary
 */

namespace Cloudinary\UI\Component;

/**
 * Class On_Off Component
 *
 * @package Cloudinary\UI
 */
class On_Off extends Text {

	/**
	 * Holds the components build blueprint.
	 *
	 * @var string
	 */
	protected $blueprint = 'wrap|span|label|title|/title|prefix/|/label|description_left/|control|false_value/|input/|shadow/|slider/|/control|description/|/span|tooltip/|/wrap';

	/**
	 * Filter the false_value parts structure.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array
	 */
	protected function false_value( $struct ) {

		$struct['element']             = 'input';
		$struct['attributes']['type']  = 'hidden';
		$struct['attributes']['name']  = $this->get_name();
		$struct['attributes']['value'] = 'off';
		unset( $struct['attributes']['class'] );
		unset( $struct['attributes']['data-bound'] );
		$struct['render'] = true;

		return $struct;
	}

	/**
	 * Sets the left hand description.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array|null
	 */
	protected function description_left( $struct ) {
		if ( $this->setting->has_param( 'description_left' ) ) {
			$struct                          = $this->description( $struct );
			$struct['attributes']['class'][] = 'left';
			$struct['content']               = $this->setting->get_param( 'description_left' );

			return $struct;
		}

		return null;
	}

	/**
	 * Filter the input parts structure.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array
	 */
	protected function input( $struct ) {

		$struct['element']                       = 'input';
		$struct['attributes']['type']            = 'checkbox';
		$struct['attributes']['name']            = $this->get_name();
		$struct['attributes']['id']              = $this->get_id();
		$struct['attributes']['value']           = 'on';
		$struct['attributes']['data-controller'] = $this->setting->get_slug();
		if ( 'on' === $this->setting->get_value() ) {
			$struct['attributes']['checked'] = 'checked';
		}
		$struct['attributes']['class'][] = 'cld-ui-input';

		$struct['render'] = true;
		if ( $this->setting->has_param( 'main' ) ) {
			$child       = $this->setting->get_param( 'main' );
			$controllers = array();
			foreach ( $child as $child_slug ) {
				$child_setting = $this->setting->find_setting( $child_slug );
				$controllers[] = $child_setting->get_slug();
			}

			$struct['attributes']['data-main'] = wp_json_encode( $controllers );
		}

		if ( $this->is_readonly() || ( true === $this->setting->has_param( 'main_required', false ) && empty( $struct['attributes']['data-main'] ) ) ) {
			$struct['attributes']['type'] = 'hidden';
		}

		return $struct;
	}

	/**
	 * Filter the shadow parts structure.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array
	 */
	protected function shadow( $struct ) {
		// Add the toggle stub.
		if ( $this->is_readonly() || ( true === $this->setting->has_param( 'main_required', false ) && empty( $struct['attributes']['data-main'] ) ) ) {
			$struct                           = $this->get_part( 'input' );
			$struct['attributes']['type']     = 'checkbox';
			$struct['attributes']['disabled'] = 'disabled';
			$struct['attributes']['checked']  = 'checked';
			$struct['attributes']['type']     = 'checkbox';
		}

		return $struct;
	}

	/**
	 * Filter the control parts structure.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array
	 */
	protected function control( $struct ) {

		$struct['element']             = 'label';
		$struct['attributes']['class'] = array(
			'cld-input-' . $this->type . '-control',
		);
		if ( true === $this->setting->get_param( 'mini', false ) ) {
			$struct['attributes']['class'][] = 'mini';
		}
		if (
			true === $this->setting->get_param( 'disabled', false )
			|| $this->is_readonly()
			|| (
				true === $this->setting->get_param( 'main_required', false )
				&& empty( $this->setting->get_param( 'main', array() ) )
			)
		) {
			$struct['attributes']['class'][] = 'disabled';
		}

		return $struct;
	}

	/**
	 * Filter the slider parts structure.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array
	 */
	protected function slider( $struct ) {
		$struct['element']             = 'span';
		$struct['render']              = true;
		$struct['attributes']['class'] = array(
			'cld-input-' . $this->type . '-control-slider',
		);
		$struct['attributes']['style'] = array();
		if ( $this->setting->has_param( 'disabled_color' ) ) {
			$struct['attributes']['style'][] = 'background-color:' . $this->setting->get_param( 'disabled_color' ) . ';';
		}

		$on                         = $this->get_part( 'i' );
		$on['attributes']['class']  = array(
			'icon-on',
			'dashicons',
			$this->setting->get_param( 'on' ),
		);
		$on['render']               = true;
		$off                        = $this->get_part( 'i' );
		$off['attributes']['class'] = array(
			'icon-off',
			'dashicons',
			$this->setting->get_param( 'off' ),
		);
		$off['render']              = true;

		$struct['children']['on']  = $on;
		$struct['children']['off'] = $off;

		return $struct;
	}

	/**
	 * Filter the tooltip structure.
	 *
	 * @param array $struct The array structure.
	 *
	 * @return array
	 */
	protected function tooltip( $struct ) {
		$struct = parent::tooltip( $struct );

		if ( $this->is_readonly() ) {
			$struct['content'] = $this->setting->get_param( 'readonly_message' );
		}

		return $struct;
	}

	/**
	 * Is toggle readonly
	 *
	 * @return bool
	 */
	protected function is_readonly() {
		return true === $this->setting->get_param( 'readonly', false ) || ( is_callable( $this->setting->get_param( 'readonly', false ) ) && call_user_func( $this->setting->get_param( 'readonly' ) ) );
	}

	/**
	 * Sanitize the value.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return bool
	 */
	public function sanitize_value( $value ) {
		$allowed = array(
			'on',
			'some',
			'off',
		);

		return in_array( $value, $allowed, true ) ? $value : 'off';
	}
}
