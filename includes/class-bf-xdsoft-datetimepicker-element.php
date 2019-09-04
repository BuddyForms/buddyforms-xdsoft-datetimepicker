<?php
/*
 * @package WordPress
 * @subpackage BuddyForms
 * @author ThemKraft Dev Team
 * @copyright 2019, ThemeKraft
 * @link http://buddyforms.com/downloads/buddyforms-woocommerce-form-elements/
 * @license GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class buddyforms_xdsoft_datetimepicker_element {
	public function __construct() {
		add_filter( 'buddyforms_formbuilder_fields_options', array( $this, 'override_date_time_new_form_element' ), 999, 5 );
		add_filter( 'buddyforms_form_before_render', array( $this, 'override_date_time_element_output', ), 10, 2 );
	}

	/**
	 * Create the form element options to use in the backend builder
	 *
	 * @param Form $form
	 * @param $form_args
	 *
	 * @return mixed
	 * @var $name
	 *
	 */
	public function override_date_time_new_form_element( $form_fields, $field_type, $field_id, $form_slug, $customfield ) {
		if ( $field_type === 'date' ) {
			$is_inline                                     = isset( $customfield['is_inline'] ) ? $customfield['is_inline'] : false;
			$form_fields['general']['element_time_format'] = new Element_Checkbox( '<b>' . __( 'Is inline', 'buddyforms' ) . '</b>', "buddyforms_options[form_fields][" . $field_id . "][is_inline]", array( 'is_inline' => '<b>' . __( 'Show the element inline', 'buddyforms' ) . '</b>' ), array(
				'value' => $is_inline,
			) );
		}

		return $form_fields;
	}

	/**
	 * @param Form $form
	 * @param $form_args
	 *
	 * @return mixed
	 */
	public function override_date_time_element_output( $form, $form_args ) {
		if ( ! empty( $form ) ) {
			$elements = $form->getElements();
			if ( ! empty( $elements ) ) {
				/**
				 * @var int $position
				 * @var Element $element
				 */
				foreach ( $elements as $position => $element ) {
					if ( $element instanceof Element_Date || $element instanceof Element_Time ) {
						$customfield = $element->getFieldOptions();
						$name        = $customfield['name'];
						$slug        = $customfield['slug'];
						$description = $customfield['description'];

						$element_attr = array(
							'id'        => str_replace( "-", "", $slug ),
							'value'     => $element->getAttribute( 'value' ),
							'class'     => 'settings-input',
							'shortDesc' => $description,
							'field_id'  => $customfield['field_id'],
							'data-form' => $form_args['form_slug']
						);

						if ( isset( $customfield['required'] ) ) {
							$element_attr = array_merge( $element_attr, array( 'required' => true ) );
						}

						if ( isset( $customfield['custom_class'] ) ) {
							$element_attr['class'] = $element_attr['class'] . ' ' . $customfield['custom_class'];
						}
						if ( $element instanceof Element_Date ) {
							$new_element = new buddyforms_xdsoft_datetimepicker_element_date( $name, $slug, $customfield, $element_attr );
							$form->overrideExistingElement( $new_element, $position );
						}
						if ( $element instanceof Element_Time ) {
							$new_element = new buddyforms_xdsoft_datetimepicker_element_time( $name, $slug, $customfield, $element_attr );
							$form->overrideExistingElement( $new_element, $position );
						}
					}
				}
			}
		}

		return $form;
	}
}