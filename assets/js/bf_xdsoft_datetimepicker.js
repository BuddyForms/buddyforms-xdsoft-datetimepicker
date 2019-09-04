function BuddyFormsXDSoftTimePicker() {
    function getFieldFromSlug(fieldSlug, formSlug) {
        if (fieldSlug && formSlug && buddyformsGlobal && buddyformsGlobal[formSlug] && buddyformsGlobal[formSlug].form_fields) {
            var fieldIdResult = Object.keys(buddyformsGlobal[formSlug].form_fields).filter(function (fieldId) {
                fieldSlug = fieldSlug.replace('[]', '');
                fieldSlug = BuddyFormsHooks.applyFilters('buddyforms:field:slug', fieldSlug, [formSlug, fieldId, buddyformsGlobal[formSlug]]);
                return buddyformsGlobal[formSlug].form_fields[fieldId].slug.toLowerCase() === fieldSlug.toLowerCase();
            });
            if (fieldIdResult) {
                return buddyformsGlobal[formSlug].form_fields[fieldIdResult];
            }
        }
        return false;
    }

    function enabledDateTime() {
        var dateElements = jQuery('.bf_xdsoft_datetimepicker');
        if (dateElements && dateElements.length > 0) {
            jQuery.each(dateElements, function (i, element) {
                var currentFieldSlug = jQuery(element).attr('name');
                var formSlug = jQuery(element).data('form');
                if (currentFieldSlug && formSlug) {
                    var fieldData = getFieldFromSlug(currentFieldSlug, formSlug);
                    var fieldTimeStep = (fieldData.element_time_step) ? fieldData.element_time_step : 60;
                    var fieldSaveFormat = (fieldData.element_save_format) ? fieldData.element_save_format : 'Y/m/d H:i';
                    var fieldDateFormat = (fieldData.element_date_format) ? fieldData.element_date_format : 'Y/m/d';
                    var fieldTimeFormat = (fieldData.element_time_format) ? fieldData.element_time_format : 'H:i';
                    var enableTime = (fieldData.enable_time && fieldData.enable_time[0] && fieldData.enable_time[0] === 'enable_time');
                    var enableDate = (fieldData.enable_date && fieldData.enable_date[0] && fieldData.enable_date[0] === 'enable_date');
                    var isInline = (fieldData.is_inline && fieldData.is_inline[0] && fieldData.is_inline[0] === 'is_inline');
                    if (!enableDate && !enableTime) {
                        enableDate = true;
                    }
                    var dateTimePickerConfig = {
                        format: fieldSaveFormat,
                        formatDate: fieldDateFormat,
                        formatTime: fieldTimeFormat,
                        datepicker: enableDate || false,
                        inline: isInline,
                        step: parseInt(fieldTimeStep)
                    };

                    jQuery(element).datetimepicker(dateTimePickerConfig);
                }
            });
        }
    }

    function enableTimeAddOn() {
        var timeElements = jQuery('.bf_xdsoft_jquerytimeaddon');
        if (timeElements && timeElements.length > 0) {
            jQuery.each(timeElements, function (i, element) {
                var currentFieldSlug = jQuery(element).attr('name');
                var formSlug = jQuery(element).data('form');
                if (currentFieldSlug && formSlug) {
                    var fieldData = getFieldFromSlug(currentFieldSlug, formSlug);

                    var fieldTimeFormat = (fieldData.element_time_format) ? fieldData.element_time_format : "h:i a";
                    var fieldStepHour = (fieldData.element_time_hour_step) ? fieldData.element_time_hour_step : 1;
                    var fieldStepMinute = (fieldData.element_time_minute_step) ? fieldData.element_time_minute_step : 1;

                    var timePickerConfig = {
                        formatTime: fieldTimeFormat,
                        format: fieldTimeFormat,
                        stepHour: fieldStepHour,
                        datepicker: false,
                        stepMinute: fieldStepMinute
                    };

                    jQuery(element).datetimepicker({
                        datepicker: false,
                        format: 'h:m a'
                    });
                }
            });
        }
    }

    return {
        init: function () {
            if (jQuery && jQuery.validator) {
                enableTimeAddOn();
                enabledDateTime();
            }
        }
    }
}

var fncBuddyFormsXDSoftTimePicker = BuddyFormsXDSoftTimePicker();
jQuery(document).ready(function () {
    fncBuddyFormsXDSoftTimePicker.init();
});
