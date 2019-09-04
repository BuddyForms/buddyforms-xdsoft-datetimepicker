<?php

/**
 * Class Element_Time
 */
class buddyforms_xdsoft_datetimepicker_element_time extends Element_Textbox {
	/**
	 * Element_Date constructor.
	 *
	 * @param $label
	 * @param $name
	 * @param $field_options
	 * @param array|null $properties
	 */
	public function __construct( $label, $name, $field_options, array $properties = null ) {
		if ( ! empty( $properties['class'] ) ) {
			$properties['class'] .= ' bf_xdsoft_jquerytimeaddon ';
		} else {
			$properties['class'] = ' bf_xdsoft_jquerytimeaddon ';
		}

		$show_label = isset( $field_options['is_inline'] ) && isset( $field_options['is_inline'][0] ) && $field_options['is_inline'][0] === 'is_inline';
		if ( $show_label ) {
			$properties['label'] = $label;
		}

		parent::__construct( $label, $name, $properties, $field_options );
	}

	public function render() {
		wp_enqueue_script( 'buddyforms-xdsoft-datetimepicker', buddyforms_xdsoft_datetimepicker::$assets . 'js/jquery.datetimepicker.full.min.js', array( 'jquery' ), buddyforms_xdsoft_datetimepicker::$version );
		wp_enqueue_style( 'buddyforms-xdsoft-datetimepicker', buddyforms_xdsoft_datetimepicker::$assets . 'css/jquery.datetimepicker.min.css', array(), buddyforms_xdsoft_datetimepicker::$version );
		wp_enqueue_script( 'buddyforms-xdsoft-datetimepicker-init', buddyforms_xdsoft_datetimepicker::$assets . 'js/bf_xdsoft_datetimepicker.js', array( 'jquery' ), buddyforms_xdsoft_datetimepicker::$version );

		$expected_format = ! empty( $this->field_options['element_time_format'] ) ? $this->field_options['element_time_format'] : '';

		if ( ! empty( $expected_format ) ) {
			$this->validation[] = new Validation_Time ( "Error: The %element% field must match the following time format: " . ! empty( $expected_format ) ? $expected_format : '', $this->field_options );
		}
		parent::render();
	}
}
