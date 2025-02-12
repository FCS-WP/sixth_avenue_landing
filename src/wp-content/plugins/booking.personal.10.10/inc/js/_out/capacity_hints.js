"use strict";

/**
 * Convert seconds to  24 hour format   3600 -> '10:00'
 * @param time_in_seconds
 * @returns {string}
 */
function wpbc_js_convert__seconds__to_time_24(time_in_seconds) {
  var hours = Math.floor(time_in_seconds % 31536000 % 86400 / 3600);
  if (86400 == time_in_seconds) {
    hours = 24;
  }
  var minutes = Math.floor(time_in_seconds % 31536000 % 86400 % 3600 / 60);
  if (hours < 10) {
    hours = '0' + hours.toString();
  }
  if (minutes < 10) {
    minutes = '0' + minutes.toString();
  }
  return hours + ':' + minutes;
}

/**
 * Convert seconds to  AM / PM time format   3600 -> '10:00 AM'
 *
 * @param time_in_seconds
 * @returns {string}
 */
function wpbc_js_convert__seconds__to_time_AMPM(time_in_seconds) {
  var hours = Math.floor(time_in_seconds % 31536000 % 86400 / 3600);
  if (86400 == time_in_seconds) {
    hours = 24;
  }
  var minutes = Math.floor(time_in_seconds % 31536000 % 86400 % 3600 / 60);

  // American Heritage Dictionary of the English Language states "By convention, 12 AM denotes midnight and 12 PM denotes NOON    -  '12:00 MIDNIGHT' for 00:00 and  - '12:00 NOON' for '12:00'
  var am_pm = parseInt(hours) > 12 ? 'PM' : 'AM';
  am_pm = 12 == hours ? 'PM' : am_pm;
  am_pm = 24 == hours ? 'AM' : am_pm;
  if (hours > 12) {
    hours = hours - 12;
  }
  // if ( hours < 10 ){
  //     hours = '0' + hours.toString();
  // }

  if (minutes < 10) {
    minutes = '0' + minutes.toString();
  }
  return hours + ':' + minutes + ' ' + am_pm;
}

/**
 * Convert Time slot from  seconds to Readable Time Format:  24 | AM/PM         [ 0, 13*60*60]  ->   '00:00 AM - 01:00 PM'    |       '00:00 - 13:00'
 *
 * @param resource_id                   int ID of resource
 * @param timeslot_in_seconds_arr       [ 0, 13*60*60]
 * @returns {string}                    '00:00 AM - 01:00 PM'    |       '00:00 - 13:00'
 */
function wpbc_js_convert__seconds__to__readable_time(resource_id, timeslot_in_seconds_arr) {
  var readable_time_format;
  var is_use_24;
  if (_wpbc.calendar__get_param_value(resource_id, 'booking_time_format').indexOf('A') > 0 || _wpbc.calendar__get_param_value(resource_id, 'booking_time_format').indexOf('a') > 0) {
    is_use_24 = false;
  } else {
    is_use_24 = true;
  }
  if (is_use_24) {
    readable_time_format = wpbc_js_convert__seconds__to_time_24(timeslot_in_seconds_arr[0]) + ' - ' + wpbc_js_convert__seconds__to_time_24(timeslot_in_seconds_arr[1]);
  } else {
    readable_time_format = wpbc_js_convert__seconds__to_time_AMPM(timeslot_in_seconds_arr[0]) + ' - ' + wpbc_js_convert__seconds__to_time_AMPM(timeslot_in_seconds_arr[1]);
  }
  return readable_time_format;
}

// =====================================================================================================================
// [capacity_hint]
// =====================================================================================================================

/**
 *  Convert times seconds arr [ 21600, 23400 ] to redable obj  {}
 *
 * @param times_as_seconds_arr      [ 21600, 23400 ]
 *
 * @returns {{value_option_24h: string[], times_as_seconds_arr, readable_time: string}}
 */
function wpbc_convert_seconds_arr__to_readable_obj(resource_id, times_as_seconds_arr) {
  var readable_time_format = wpbc_js_convert__seconds__to__readable_time(resource_id, times_as_seconds_arr);
  var obj = {
    'times_as_seconds': wpbc_clone_obj(times_as_seconds_arr),
    'value_option_24h': [wpbc_js_convert__seconds__to_time_24(times_as_seconds_arr[0]), wpbc_js_convert__seconds__to_time_24(times_as_seconds_arr[1])],
    'readable_time': readable_time_format
  };
  return obj;
}
function wpbc_get_start_end_times_sec_arr__for_all_rangetime_slots_in_booking_form(resource_id) {
  // [ {jquery_option: {}, name: "rangetime2", times_as_seconds:[ 36000, 43200 ], value_option_24h: "10:00 - 12:00"} , ... ]
  var is_only_selected_time = false;
  var all_time_fields = wpbc_get__selected_time_fields__in_booking_form__as_arr(resource_id, is_only_selected_time);
  var time_as_seconds_arr = [];
  for (var t_key in all_time_fields) {
    if (all_time_fields[t_key]['name'].indexOf('rangetime') > -1) {
      time_as_seconds_arr.push(wpbc_convert_seconds_arr__to_readable_obj(resource_id, all_time_fields[t_key].times_as_seconds // { times_as_seconds: [ 21600, 23400 ], value_option_24h: '06:00 - 06:30', name: 'rangetime2[]', jquery_option: jQuery_Object {}}
      ));
    }
  }
  return time_as_seconds_arr;
}

/**
 * Get array  of available items for each  seelcted date and time slot in booking form
 *
 * @param int resource_id
 * @returns [
 *
 *              "2024-05-17": [
 *                              0_86400    : Object { available_items: 4, value_option_24h: "00:00 - 24:00", date_sql_key: "2024-05-17", … }
 *                              36000_43200: Object { available_items: 4, value_option_24h: "10:00 - 12:00", date_sql_key: "2024-05-17", … }
 *                              43200_50400: Object { available_items: 4, value_option_24h: "12:00 - 14:00", date_sql_key: "2024-05-17", … }
 *                              50400_57600: Object { available_items: 4, value_option_24h: "14:00 - 16:00", date_sql_key: "2024-05-17", … }
 *                              57600_64800: Object { available_items: 4, value_option_24h: "16:00 - 18:00", date_sql_key: "2024-05-17", … }
 *                              64800_72000: Object { available_items: 4, value_option_24h: "18:00 - 20:00", date_sql_key: "2024-05-17", … }
 *                            ]
 *              "2024-05-19": [
 *                              0_86400    : Object { available_items: 4, value_option_24h: "00:00 - 24:00", date_sql_key: "2024-05-19", … }
 *                              36000_43200: Object { available_items: 4, value_option_24h: "10:00 - 12:00", date_sql_key: "2024-05-19", … }
 *                              43200_50400: Object { available_items: 4, value_option_24h: "12:00 - 14:00", date_sql_key: "2024-05-19", … }
 *                              50400_57600: Object { available_items: 4, value_option_24h: "14:00 - 16:00", date_sql_key: "2024-05-19", … }
 *                              57600_64800: Object { available_items: 4, value_option_24h: "16:00 - 18:00", date_sql_key: "2024-05-19", … }
 *                              64800_72000: Object { availa...
 *                            ]
 *          ]
 */
function wpbc_get__available_items_for_selected_datetime(resource_id) {
  var selected_time_fields = [];

  // -------------------------------------------------------------------------------------------------------------
  // This is current selected / entered  ONE time slot  (if not entred time,  then  full date)
  // -------------------------------------------------------------------------------------------------------------
  // [ 0 , 24 * 60 * 60 ]  |  [ 12*60*60 , 14*60*60 ]    This is selected,  entered times. So  we will  show available slots only  for selected times
  var time_to_book__as_seconds_arr = wpbc_get_start_end_times__in_booking_form__as_seconds(resource_id);
  // [ 12*60*60 , 14*60*60 ]
  selected_time_fields.push(wpbc_convert_seconds_arr__to_readable_obj(resource_id, time_to_book__as_seconds_arr));

  // -------------------------------------------------------------------------------------------------------------
  // This is all  time-slots from  range-time,  if any
  var all_rangetime_slots_arr = wpbc_get_start_end_times_sec_arr__for_all_rangetime_slots_in_booking_form(resource_id);
  // -------------------------------------------------------------------------------------------------------------

  var work_times_array = all_rangetime_slots_arr.length > 0 ? wpbc_clone_obj(all_rangetime_slots_arr) : wpbc_clone_obj(selected_time_fields);
  var capacity_dates_times = [];
  for (var obj_key in work_times_array) {
    // Object { name: "rangetime2", value_option_24h: "10:00 - 12:00", jquery_option: {…}, name: "rangetime2", times_as_seconds: Array [ 36000, 43200 ], value_option_24h: "10:00 - 12:00" }
    var one_times_readable_obj = work_times_array[obj_key];

    // '43200_50400'
    var time_key = '' + one_times_readable_obj['times_as_seconds'][0] + '_' + one_times_readable_obj['times_as_seconds'][1];

    /**
     *  [   "2024-05-16": [  0: Object { resource_id: 2,  is_available: true, booked__seconds: [], … }
     *                       1: Object { resource_id: 10, is_available: true, booked__seconds: [], … }
     *                       2: Object { resource_id: 11, is_available: true, booked__seconds: [], … }
     *   ]
     */
    var available_slots_by_dates = wpbc__get_available_slots__for_selected_dates_times__bl(resource_id, wpbc_clone_obj(one_times_readable_obj['times_as_seconds']));
    //console.log( 'available_slots_by_dates==',available_slots_by_dates);

    // Loop Dates
    for (var date_sql_key in available_slots_by_dates) {
      var available_slots_in_one_date = available_slots_by_dates[date_sql_key];
      var count_available_slots = 0;
      var time2book_in_sec_per_each_date = wpbc_clone_obj(one_times_readable_obj['times_as_seconds']);

      // Loop Available Slots in Date
      for (var i = 0; i < available_slots_in_one_date.length; i++) {
        if (available_slots_in_one_date[i]['is_available']) {
          count_available_slots++;
        }

        // Ovveride that  time by  times,  that  can  be different for several  dates,  if deactivated this option: 'Use selected times for each booking date'
        // For example if slecte time 10:00 - 11:00 and selected 3 dates, then  booked times here will be  10:00 - 24:00,   00:00 - 24:00,   00:00 - 11:00
        time2book_in_sec_per_each_date = wpbc_clone_obj(available_slots_in_one_date[i]['time_to_book__seconds']);
      }

      // Save info
      if ('undefined' === typeof capacity_dates_times[date_sql_key]) {
        capacity_dates_times[date_sql_key] = [];
      }
      var css_class = '';
      if (selected_time_fields.length > 0) {
        if (selected_time_fields[0]['times_as_seconds'][0] == time2book_in_sec_per_each_date[0] && selected_time_fields[0]['times_as_seconds'][1] == time2book_in_sec_per_each_date[1]) {
          css_class += ' wpbc_selected_timeslot';
        }
      }

      // -----------------------------------------------------------------------------------------------------
      // Readable Time Format:  24 | AM/PM
      // -----------------------------------------------------------------------------------------------------
      var readable_time_format = wpbc_js_convert__seconds__to__readable_time(resource_id, time2book_in_sec_per_each_date);
      capacity_dates_times[date_sql_key][time_key] = {
        // 'value_option_24h':one_times_readable_obj[ 'value_option_24h' ],
        'available_items': count_available_slots,
        'times_as_seconds': time2book_in_sec_per_each_date,
        'date_sql_key': date_sql_key,
        'readable_time': readable_time_format,
        'css_class': css_class
      };
    }
  }
  return capacity_dates_times;
}

// ---------------------------------------------------------------------------------------------------------------------
// Template for shortcode hint
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Update time hint shortcode content in booking form
 *
 * @param resource_id
 */
function wpbc_update_capacity_hint(resource_id) {
  /**
  *  [          "2024-05-17": [
  *                              0_86400    : Object { available_items: 4, value_option_24h: "00:00 - 24:00", date_sql_key: "2024-05-17", … }
  *                              36000_43200: Object { available_items: 4, value_option_24h: "10:00 - 12:00", date_sql_key: "2024-05-17", … }
  *                              43200_50400: Object { available_items: 4, value_option_24h: "12:00 - 14:00", date_sql_key: "2024-05-17", … }
  *                              50400_57600: Object { available_items: 4, value_option_24h: "14:00 - 16:00", date_sql_key: "2024-05-17", … }
  *                              57600_64800: Object { available_items: 4, value_option_24h: "16:00 - 18:00", date_sql_key: "2024-05-17", … }
  *                              64800_72000: Object { available_items: 4, value_option_24h: "18:00 - 20:00", date_sql_key: "2024-05-17", … }
  *                            ]
  *              "2024-05-19": [
  *                              0_86400    : Object { available_items: 4, value_option_24h: "00:00 - 24:00", date_sql_key: "2024-05-19", … }
  *                              36000_43200: Object { available_items: 4, value_option_24h: "10:00 - 12:00", date_sql_key: "2024-05-19", … }
  *                              43200_50400: Object { available_items: 4, value_option_24h: "12:00 - 14:00", date_sql_key: "2024-05-19", … }
  *                              50400_57600: Object { available_items: 4, value_option_24h: "14:00 - 16:00", date_sql_key: "2024-05-19", … }
  *                              57600_64800: Object { available_items: 4, value_option_24h: "16:00 - 18:00", date_sql_key: "2024-05-19", … }
  *                              64800_72000: Object { availa...
  *                            ]
  *          ]
  */
  var available_items_arr = wpbc_get__available_items_for_selected_datetime(resource_id);
  var is_full_day_booking = true;
  for (var obj_date_tag in available_items_arr) {
    if (Object.keys(available_items_arr[obj_date_tag]).length > 1) {
      is_full_day_booking = false;
      break;
    }
    for (var time_key in available_items_arr[obj_date_tag]) {
      if (available_items_arr[obj_date_tag][time_key]['times_as_seconds'][0] > 0 && available_items_arr[obj_date_tag][time_key]['times_as_seconds'][1] < 86400) {
        is_full_day_booking = false;
        break;
      }
    }
    if (!is_full_day_booking) {
      break;
    }
  }
  var css_is_full_day_booking = is_full_day_booking ? ' wpbc_chint__full_day_bookings' : '';
  var tooltip_hint = '<div class="wpbc_capacity_hint_container' + css_is_full_day_booking + '">';
  for (var obj_date_tag in available_items_arr) {
    var timeslots_in_day = available_items_arr[obj_date_tag];
    tooltip_hint += '<div class="wpbc_chint__datetime_container">';

    // JSON.stringify(available_items_arr).match(/[^\\]":/g).length
    if (Object.keys(available_items_arr).length > 1 || is_full_day_booking) {
      tooltip_hint += '<div class="wpbc_chint__date_container">';
      tooltip_hint += '<div class="wpbc_chint__date">' + obj_date_tag + '</div> ';
      tooltip_hint += '<div class="wpbc_chint__date_divider">:</div> ';
      tooltip_hint += '</div> ';
    }
    for (var time_key in timeslots_in_day) {
      tooltip_hint += '<div class="wpbc_chint__time_container">';

      // If not full day booking: e.g  00:00 - 24:00
      //if ( (timeslots_in_day[ time_key ][ 'times_as_seconds' ][ 0 ] > 0) && (timeslots_in_day[ time_key ][ 'times_as_seconds' ][ 1 ] < 86400) ){

      tooltip_hint += '<div class="wpbc_chint__timeslot ' + timeslots_in_day[time_key]['css_class'] + '">' + timeslots_in_day[time_key]['readable_time'] + '</div> ';
      tooltip_hint += '<div class="wpbc_chint__timeslot_divider">: </div> ';
      //}

      tooltip_hint += '<div class="wpbc_chint__availability availability_num_' + timeslots_in_day[time_key]['available_items'] + '">' + timeslots_in_day[time_key]['available_items'] + '</div> ';
      tooltip_hint += '</div> ';
    }
    tooltip_hint += '</div> ';
  }
  tooltip_hint += '</div> ';

  //console.log( ':: available_items_arr ::', available_items_arr );

  jQuery('.capacity_hint_' + resource_id).html(tooltip_hint);
  jQuery('.capacity_hint_' + resource_id).removeClass('wpbc_chin_newline');
  if (Object.keys(available_items_arr).length > 1) {
    jQuery('.capacity_hint_' + resource_id).addClass('wpbc_chin_newline');
  }
}

// Run shortcode changing after  dates selection,  and options selection.
jQuery(document).ready(function () {
  jQuery('.booking_form_div').on('wpbc_booking_date_or_option_selected', function (event, resource_id) {
    wpbc_update_capacity_hint(resource_id);
  });
});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiaW5jL2pzL19vdXQvY2FwYWNpdHlfaGludHMuanMiLCJuYW1lcyI6WyJ3cGJjX2pzX2NvbnZlcnRfX3NlY29uZHNfX3RvX3RpbWVfMjQiLCJ0aW1lX2luX3NlY29uZHMiLCJob3VycyIsIk1hdGgiLCJmbG9vciIsIm1pbnV0ZXMiLCJ0b1N0cmluZyIsIndwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fdGltZV9BTVBNIiwiYW1fcG0iLCJwYXJzZUludCIsIndwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fX3JlYWRhYmxlX3RpbWUiLCJyZXNvdXJjZV9pZCIsInRpbWVzbG90X2luX3NlY29uZHNfYXJyIiwicmVhZGFibGVfdGltZV9mb3JtYXQiLCJpc191c2VfMjQiLCJfd3BiYyIsImNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUiLCJpbmRleE9mIiwid3BiY19jb252ZXJ0X3NlY29uZHNfYXJyX190b19yZWFkYWJsZV9vYmoiLCJ0aW1lc19hc19zZWNvbmRzX2FyciIsIm9iaiIsIndwYmNfY2xvbmVfb2JqIiwid3BiY19nZXRfc3RhcnRfZW5kX3RpbWVzX3NlY19hcnJfX2Zvcl9hbGxfcmFuZ2V0aW1lX3Nsb3RzX2luX2Jvb2tpbmdfZm9ybSIsImlzX29ubHlfc2VsZWN0ZWRfdGltZSIsImFsbF90aW1lX2ZpZWxkcyIsIndwYmNfZ2V0X19zZWxlY3RlZF90aW1lX2ZpZWxkc19faW5fYm9va2luZ19mb3JtX19hc19hcnIiLCJ0aW1lX2FzX3NlY29uZHNfYXJyIiwidF9rZXkiLCJwdXNoIiwidGltZXNfYXNfc2Vjb25kcyIsIndwYmNfZ2V0X19hdmFpbGFibGVfaXRlbXNfZm9yX3NlbGVjdGVkX2RhdGV0aW1lIiwic2VsZWN0ZWRfdGltZV9maWVsZHMiLCJ0aW1lX3RvX2Jvb2tfX2FzX3NlY29uZHNfYXJyIiwid3BiY19nZXRfc3RhcnRfZW5kX3RpbWVzX19pbl9ib29raW5nX2Zvcm1fX2FzX3NlY29uZHMiLCJhbGxfcmFuZ2V0aW1lX3Nsb3RzX2FyciIsIndvcmtfdGltZXNfYXJyYXkiLCJsZW5ndGgiLCJjYXBhY2l0eV9kYXRlc190aW1lcyIsIm9ial9rZXkiLCJvbmVfdGltZXNfcmVhZGFibGVfb2JqIiwidGltZV9rZXkiLCJhdmFpbGFibGVfc2xvdHNfYnlfZGF0ZXMiLCJ3cGJjX19nZXRfYXZhaWxhYmxlX3Nsb3RzX19mb3Jfc2VsZWN0ZWRfZGF0ZXNfdGltZXNfX2JsIiwiZGF0ZV9zcWxfa2V5IiwiYXZhaWxhYmxlX3Nsb3RzX2luX29uZV9kYXRlIiwiY291bnRfYXZhaWxhYmxlX3Nsb3RzIiwidGltZTJib29rX2luX3NlY19wZXJfZWFjaF9kYXRlIiwiaSIsImNzc19jbGFzcyIsIndwYmNfdXBkYXRlX2NhcGFjaXR5X2hpbnQiLCJhdmFpbGFibGVfaXRlbXNfYXJyIiwiaXNfZnVsbF9kYXlfYm9va2luZyIsIm9ial9kYXRlX3RhZyIsIk9iamVjdCIsImtleXMiLCJjc3NfaXNfZnVsbF9kYXlfYm9va2luZyIsInRvb2x0aXBfaGludCIsInRpbWVzbG90c19pbl9kYXkiLCJqUXVlcnkiLCJodG1sIiwicmVtb3ZlQ2xhc3MiLCJhZGRDbGFzcyIsImRvY3VtZW50IiwicmVhZHkiLCJvbiIsImV2ZW50Il0sInNvdXJjZXMiOlsiaW5jL2pzL19zcmMvY2FwYWNpdHlfaGludHMuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLyoqXHJcbiAqIENvbnZlcnQgc2Vjb25kcyB0byAgMjQgaG91ciBmb3JtYXQgICAzNjAwIC0+ICcxMDowMCdcclxuICogQHBhcmFtIHRpbWVfaW5fc2Vjb25kc1xyXG4gKiBAcmV0dXJucyB7c3RyaW5nfVxyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19qc19jb252ZXJ0X19zZWNvbmRzX190b190aW1lXzI0KCB0aW1lX2luX3NlY29uZHMgKXtcclxuXHJcbiAgICB2YXIgaG91cnMgICA9IE1hdGguZmxvb3IoICggICAodGltZV9pbl9zZWNvbmRzICUgMzE1MzYwMDApICUgODY0MDApIC8gMzYwMCApO1xyXG4gICAgaWYgKCA4NjQwMCA9PSB0aW1lX2luX3NlY29uZHMgKXtcclxuICAgICAgICBob3VycyA9IDI0O1xyXG4gICAgfVxyXG4gICAgdmFyIG1pbnV0ZXMgPSBNYXRoLmZsb29yKCAoICggKHRpbWVfaW5fc2Vjb25kcyAlIDMxNTM2MDAwKSAlIDg2NDAwKSAlIDM2MDAgKSAvIDYwICk7XHJcblxyXG4gICAgaWYgKCBob3VycyA8IDEwICl7XHJcbiAgICAgICAgaG91cnMgPSAnMCcgKyBob3Vycy50b1N0cmluZygpO1xyXG4gICAgfVxyXG4gICAgaWYgKCBtaW51dGVzIDwgMTAgKXtcclxuICAgICAgICBtaW51dGVzID0gJzAnICsgbWludXRlcy50b1N0cmluZygpO1xyXG4gICAgfVxyXG5cclxuICAgIHJldHVybiBob3VycyArICc6JyArIG1pbnV0ZXM7XHJcbn1cclxuXHJcblxyXG4vKipcclxuICogQ29udmVydCBzZWNvbmRzIHRvICBBTSAvIFBNIHRpbWUgZm9ybWF0ICAgMzYwMCAtPiAnMTA6MDAgQU0nXHJcbiAqXHJcbiAqIEBwYXJhbSB0aW1lX2luX3NlY29uZHNcclxuICogQHJldHVybnMge3N0cmluZ31cclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fdGltZV9BTVBNKCB0aW1lX2luX3NlY29uZHMgKXtcclxuXHJcbiAgICB2YXIgaG91cnMgICA9IE1hdGguZmxvb3IoICggICAodGltZV9pbl9zZWNvbmRzICUgMzE1MzYwMDApICUgODY0MDApIC8gMzYwMCApO1xyXG4gICAgaWYgKCA4NjQwMCA9PSB0aW1lX2luX3NlY29uZHMgKXtcclxuICAgICAgICBob3VycyA9IDI0O1xyXG4gICAgfVxyXG4gICAgdmFyIG1pbnV0ZXMgPSBNYXRoLmZsb29yKCAoICggKHRpbWVfaW5fc2Vjb25kcyAlIDMxNTM2MDAwKSAlIDg2NDAwKSAlIDM2MDAgKSAvIDYwICk7XHJcblxyXG4gICAgLy8gQW1lcmljYW4gSGVyaXRhZ2UgRGljdGlvbmFyeSBvZiB0aGUgRW5nbGlzaCBMYW5ndWFnZSBzdGF0ZXMgXCJCeSBjb252ZW50aW9uLCAxMiBBTSBkZW5vdGVzIG1pZG5pZ2h0IGFuZCAxMiBQTSBkZW5vdGVzIE5PT04gICAgLSAgJzEyOjAwIE1JRE5JR0hUJyBmb3IgMDA6MDAgYW5kICAtICcxMjowMCBOT09OJyBmb3IgJzEyOjAwJ1xyXG4gICAgdmFyIGFtX3BtID0gKHBhcnNlSW50KCBob3VycyApID4gMTIpID8gJ1BNJyA6ICdBTSc7XHJcbiAgICBhbV9wbSA9ICgxMiA9PSBob3VycykgPyAnUE0nIDogYW1fcG07XHJcbiAgICBhbV9wbSA9ICgyNCA9PSBob3VycykgPyAnQU0nIDogYW1fcG07XHJcblxyXG4gICAgaWYgKCBob3VycyA+IDEyICl7XHJcbiAgICAgICAgaG91cnMgPSBob3VycyAtIDEyO1xyXG4gICAgfVxyXG4gICAgLy8gaWYgKCBob3VycyA8IDEwICl7XHJcbiAgICAvLyAgICAgaG91cnMgPSAnMCcgKyBob3Vycy50b1N0cmluZygpO1xyXG4gICAgLy8gfVxyXG5cclxuICAgIGlmICggbWludXRlcyA8IDEwICl7XHJcbiAgICAgICAgbWludXRlcyA9ICcwJyArIG1pbnV0ZXMudG9TdHJpbmcoKTtcclxuICAgIH1cclxuXHJcbiAgICByZXR1cm4gaG91cnMgKyAnOicgKyBtaW51dGVzICsgJyAnICsgYW1fcG07XHJcbn1cclxuXHJcblxyXG4vKipcclxuICogQ29udmVydCBUaW1lIHNsb3QgZnJvbSAgc2Vjb25kcyB0byBSZWFkYWJsZSBUaW1lIEZvcm1hdDogIDI0IHwgQU0vUE0gICAgICAgICBbIDAsIDEzKjYwKjYwXSAgLT4gICAnMDA6MDAgQU0gLSAwMTowMCBQTScgICAgfCAgICAgICAnMDA6MDAgLSAxMzowMCdcclxuICpcclxuICogQHBhcmFtIHJlc291cmNlX2lkICAgICAgICAgICAgICAgICAgIGludCBJRCBvZiByZXNvdXJjZVxyXG4gKiBAcGFyYW0gdGltZXNsb3RfaW5fc2Vjb25kc19hcnIgICAgICAgWyAwLCAxMyo2MCo2MF1cclxuICogQHJldHVybnMge3N0cmluZ30gICAgICAgICAgICAgICAgICAgICcwMDowMCBBTSAtIDAxOjAwIFBNJyAgICB8ICAgICAgICcwMDowMCAtIDEzOjAwJ1xyXG4gKi9cclxuZnVuY3Rpb24gd3BiY19qc19jb252ZXJ0X19zZWNvbmRzX190b19fcmVhZGFibGVfdGltZSggcmVzb3VyY2VfaWQsIHRpbWVzbG90X2luX3NlY29uZHNfYXJyICl7XHJcblxyXG4gICAgdmFyIHJlYWRhYmxlX3RpbWVfZm9ybWF0O1xyXG4gICAgdmFyIGlzX3VzZV8yNDtcclxuICAgIGlmIChcclxuICAgICAgICAgICAoIF93cGJjLmNhbGVuZGFyX19nZXRfcGFyYW1fdmFsdWUoIHJlc291cmNlX2lkLCAnYm9va2luZ190aW1lX2Zvcm1hdCcgKS5pbmRleE9mKCAnQScgKSA+IDAgKVxyXG4gICAgICAgIHx8ICggX3dwYmMuY2FsZW5kYXJfX2dldF9wYXJhbV92YWx1ZSggcmVzb3VyY2VfaWQsICdib29raW5nX3RpbWVfZm9ybWF0JyApLmluZGV4T2YoICdhJyApID4gMCApXHJcblxyXG4gICAgKSB7XHJcbiAgICAgICAgaXNfdXNlXzI0ID0gZmFsc2U7XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICAgIGlzX3VzZV8yNCA9IHRydWU7XHJcbiAgICB9XHJcblxyXG4gICAgaWYgKCBpc191c2VfMjQgKXtcclxuICAgICAgICByZWFkYWJsZV90aW1lX2Zvcm1hdCA9IHdwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fdGltZV8yNCggdGltZXNsb3RfaW5fc2Vjb25kc19hcnJbIDAgXSApXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICArICcgLSAnXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICArIHdwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fdGltZV8yNCggdGltZXNsb3RfaW5fc2Vjb25kc19hcnJbIDEgXSApO1xyXG4gICAgfSBlbHNlIHtcclxuICAgICAgICByZWFkYWJsZV90aW1lX2Zvcm1hdCA9IHdwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fdGltZV9BTVBNKCB0aW1lc2xvdF9pbl9zZWNvbmRzX2FyclsgMCBdIClcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICsgJyAtICdcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICsgd3BiY19qc19jb252ZXJ0X19zZWNvbmRzX190b190aW1lX0FNUE0oIHRpbWVzbG90X2luX3NlY29uZHNfYXJyWyAxIF0gKTtcclxuICAgIH1cclxuXHJcbiAgICByZXR1cm4gcmVhZGFibGVfdGltZV9mb3JtYXQ7XHJcbn1cclxuXHJcblxyXG5cclxuLy8gPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbi8vIFtjYXBhY2l0eV9oaW50XVxyXG4vLyA9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuXHJcbiAgICAvKipcclxuICAgICAqICBDb252ZXJ0IHRpbWVzIHNlY29uZHMgYXJyIFsgMjE2MDAsIDIzNDAwIF0gdG8gcmVkYWJsZSBvYmogIHt9XHJcbiAgICAgKlxyXG4gICAgICogQHBhcmFtIHRpbWVzX2FzX3NlY29uZHNfYXJyICAgICAgWyAyMTYwMCwgMjM0MDAgXVxyXG4gICAgICpcclxuICAgICAqIEByZXR1cm5zIHt7dmFsdWVfb3B0aW9uXzI0aDogc3RyaW5nW10sIHRpbWVzX2FzX3NlY29uZHNfYXJyLCByZWFkYWJsZV90aW1lOiBzdHJpbmd9fVxyXG4gICAgICovXHJcbiAgICBmdW5jdGlvbiB3cGJjX2NvbnZlcnRfc2Vjb25kc19hcnJfX3RvX3JlYWRhYmxlX29iaiggcmVzb3VyY2VfaWQsIHRpbWVzX2FzX3NlY29uZHNfYXJyICl7XHJcblxyXG5cclxuICAgICAgICB2YXIgcmVhZGFibGVfdGltZV9mb3JtYXQgPSB3cGJjX2pzX2NvbnZlcnRfX3NlY29uZHNfX3RvX19yZWFkYWJsZV90aW1lKCByZXNvdXJjZV9pZCwgdGltZXNfYXNfc2Vjb25kc19hcnIgKTtcclxuXHJcbiAgICAgICAgdmFyIG9iaiA9IHtcclxuICAgICAgICAgICAgJ3RpbWVzX2FzX3NlY29uZHMnOiB3cGJjX2Nsb25lX29iaiggdGltZXNfYXNfc2Vjb25kc19hcnIgKSxcclxuICAgICAgICAgICAgJ3ZhbHVlX29wdGlvbl8yNGgnOiBbXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHdwYmNfanNfY29udmVydF9fc2Vjb25kc19fdG9fdGltZV8yNCggdGltZXNfYXNfc2Vjb25kc19hcnJbIDAgXSApLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB3cGJjX2pzX2NvbnZlcnRfX3NlY29uZHNfX3RvX3RpbWVfMjQoIHRpbWVzX2FzX3NlY29uZHNfYXJyWyAxIF0gKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF0sXHJcbiAgICAgICAgICAgICdyZWFkYWJsZV90aW1lJyAgIDogcmVhZGFibGVfdGltZV9mb3JtYXRcclxuICAgICAgICB9O1xyXG4gICAgICAgIHJldHVybiBvYmo7XHJcbiAgICB9XHJcblxyXG5cclxuICAgIGZ1bmN0aW9uIHdwYmNfZ2V0X3N0YXJ0X2VuZF90aW1lc19zZWNfYXJyX19mb3JfYWxsX3JhbmdldGltZV9zbG90c19pbl9ib29raW5nX2Zvcm0oIHJlc291cmNlX2lkICl7XHJcblxyXG4gICAgICAgIC8vIFsge2pxdWVyeV9vcHRpb246IHt9LCBuYW1lOiBcInJhbmdldGltZTJcIiwgdGltZXNfYXNfc2Vjb25kczpbIDM2MDAwLCA0MzIwMCBdLCB2YWx1ZV9vcHRpb25fMjRoOiBcIjEwOjAwIC0gMTI6MDBcIn0gLCAuLi4gXVxyXG4gICAgICAgIHZhciBpc19vbmx5X3NlbGVjdGVkX3RpbWUgPSBmYWxzZTtcclxuICAgICAgICB2YXIgYWxsX3RpbWVfZmllbGRzID0gd3BiY19nZXRfX3NlbGVjdGVkX3RpbWVfZmllbGRzX19pbl9ib29raW5nX2Zvcm1fX2FzX2FyciggcmVzb3VyY2VfaWQgLCBpc19vbmx5X3NlbGVjdGVkX3RpbWUgKTtcclxuXHJcbiAgICAgICAgdmFyIHRpbWVfYXNfc2Vjb25kc19hcnIgPSBbXTtcclxuXHJcbiAgICAgICAgZm9yICggdmFyIHRfa2V5IGluIGFsbF90aW1lX2ZpZWxkcyApe1xyXG5cclxuICAgICAgICAgICAgaWYgKCBhbGxfdGltZV9maWVsZHNbIHRfa2V5IF1bICduYW1lJyBdLmluZGV4T2YoICdyYW5nZXRpbWUnICkgPiAtMSApe1xyXG5cclxuICAgICAgICAgICAgICAgIHRpbWVfYXNfc2Vjb25kc19hcnIucHVzaChcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB3cGJjX2NvbnZlcnRfc2Vjb25kc19hcnJfX3RvX3JlYWRhYmxlX29iaiggIHJlc291cmNlX2lkLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYWxsX3RpbWVfZmllbGRzWyB0X2tleSBdLnRpbWVzX2FzX3NlY29uZHMgICAgICAgICAgICAgICAvLyB7IHRpbWVzX2FzX3NlY29uZHM6IFsgMjE2MDAsIDIzNDAwIF0sIHZhbHVlX29wdGlvbl8yNGg6ICcwNjowMCAtIDA2OjMwJywgbmFtZTogJ3JhbmdldGltZTJbXScsIGpxdWVyeV9vcHRpb246IGpRdWVyeV9PYmplY3Qge319XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgcmV0dXJuIHRpbWVfYXNfc2Vjb25kc19hcnI7XHJcbiAgICB9XHJcblxyXG5cclxuICAgIC8qKlxyXG4gICAgICogR2V0IGFycmF5ICBvZiBhdmFpbGFibGUgaXRlbXMgZm9yIGVhY2ggIHNlZWxjdGVkIGRhdGUgYW5kIHRpbWUgc2xvdCBpbiBib29raW5nIGZvcm1cclxuICAgICAqXHJcbiAgICAgKiBAcGFyYW0gaW50IHJlc291cmNlX2lkXHJcbiAgICAgKiBAcmV0dXJucyBbXHJcbiAgICAgKlxyXG4gICAgICogICAgICAgICAgICAgIFwiMjAyNC0wNS0xN1wiOiBbXHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDBfODY0MDAgICAgOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMDA6MDAgLSAyNDowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xN1wiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAzNjAwMF80MzIwMDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjEwOjAwIC0gMTI6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTdcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgNDMyMDBfNTA0MDA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIxMjowMCAtIDE0OjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE3XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDUwNDAwXzU3NjAwOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMTQ6MDAgLSAxNjowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xN1wiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICA1NzYwMF82NDgwMDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjE2OjAwIC0gMTg6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTdcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgNjQ4MDBfNzIwMDA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIxODowMCAtIDIwOjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE3XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICBdXHJcbiAgICAgKiAgICAgICAgICAgICAgXCIyMDI0LTA1LTE5XCI6IFtcclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgMF84NjQwMCAgICA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIwMDowMCAtIDI0OjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE5XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDM2MDAwXzQzMjAwOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMTA6MDAgLSAxMjowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xOVwiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICA0MzIwMF81MDQwMDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjEyOjAwIC0gMTQ6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTlcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgNTA0MDBfNTc2MDA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIxNDowMCAtIDE2OjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE5XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDU3NjAwXzY0ODAwOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMTY6MDAgLSAxODowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xOVwiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICA2NDgwMF83MjAwMDogT2JqZWN0IHsgYXZhaWxhLi4uXHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICBdXHJcbiAgICAgKiAgICAgICAgICBdXHJcbiAgICAgKi9cclxuICAgIGZ1bmN0aW9uIHdwYmNfZ2V0X19hdmFpbGFibGVfaXRlbXNfZm9yX3NlbGVjdGVkX2RhdGV0aW1lKCByZXNvdXJjZV9pZCApe1xyXG5cclxuICAgICAgICAgdmFyIHNlbGVjdGVkX3RpbWVfZmllbGRzID0gW107XHJcblxyXG4gICAgICAgIC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICAgICAgICAvLyBUaGlzIGlzIGN1cnJlbnQgc2VsZWN0ZWQgLyBlbnRlcmVkICBPTkUgdGltZSBzbG90ICAoaWYgbm90IGVudHJlZCB0aW1lLCAgdGhlbiAgZnVsbCBkYXRlKVxyXG4gICAgICAgIC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICAgICAgICAvLyBbIDAgLCAyNCAqIDYwICogNjAgXSAgfCAgWyAxMio2MCo2MCAsIDE0KjYwKjYwIF0gICAgVGhpcyBpcyBzZWxlY3RlZCwgIGVudGVyZWQgdGltZXMuIFNvICB3ZSB3aWxsICBzaG93IGF2YWlsYWJsZSBzbG90cyBvbmx5ICBmb3Igc2VsZWN0ZWQgdGltZXNcclxuICAgICAgICB2YXIgdGltZV90b19ib29rX19hc19zZWNvbmRzX2FyciA9IHdwYmNfZ2V0X3N0YXJ0X2VuZF90aW1lc19faW5fYm9va2luZ19mb3JtX19hc19zZWNvbmRzKCByZXNvdXJjZV9pZCApO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vIFsgMTIqNjAqNjAgLCAxNCo2MCo2MCBdXHJcbiAgICAgICAgc2VsZWN0ZWRfdGltZV9maWVsZHMucHVzaCggIHdwYmNfY29udmVydF9zZWNvbmRzX2Fycl9fdG9fcmVhZGFibGVfb2JqKCByZXNvdXJjZV9pZCwgdGltZV90b19ib29rX19hc19zZWNvbmRzX2FyciApICk7XHJcblxyXG4gICAgICAgIC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICAgICAgICAvLyBUaGlzIGlzIGFsbCAgdGltZS1zbG90cyBmcm9tICByYW5nZS10aW1lLCAgaWYgYW55XHJcbiAgICAgICAgdmFyIGFsbF9yYW5nZXRpbWVfc2xvdHNfYXJyID0gd3BiY19nZXRfc3RhcnRfZW5kX3RpbWVzX3NlY19hcnJfX2Zvcl9hbGxfcmFuZ2V0aW1lX3Nsb3RzX2luX2Jvb2tpbmdfZm9ybSggcmVzb3VyY2VfaWQgKTtcclxuICAgICAgICAvLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcblxyXG5cclxuICAgICAgICB2YXIgd29ya190aW1lc19hcnJheSA9IChhbGxfcmFuZ2V0aW1lX3Nsb3RzX2Fyci5sZW5ndGggPiAwKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA/IHdwYmNfY2xvbmVfb2JqKCBhbGxfcmFuZ2V0aW1lX3Nsb3RzX2FyciApXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDogd3BiY19jbG9uZV9vYmooIHNlbGVjdGVkX3RpbWVfZmllbGRzICk7XHJcblxyXG4gICAgICAgIHZhciBjYXBhY2l0eV9kYXRlc190aW1lcyA9IFtdO1xyXG5cclxuICAgICAgICBmb3IgKCB2YXIgb2JqX2tleSBpbiB3b3JrX3RpbWVzX2FycmF5ICl7XHJcblxyXG4gICAgICAgICAgICAvLyBPYmplY3QgeyBuYW1lOiBcInJhbmdldGltZTJcIiwgdmFsdWVfb3B0aW9uXzI0aDogXCIxMDowMCAtIDEyOjAwXCIsIGpxdWVyeV9vcHRpb246IHvigKZ9LCBuYW1lOiBcInJhbmdldGltZTJcIiwgdGltZXNfYXNfc2Vjb25kczogQXJyYXkgWyAzNjAwMCwgNDMyMDAgXSwgdmFsdWVfb3B0aW9uXzI0aDogXCIxMDowMCAtIDEyOjAwXCIgfVxyXG4gICAgICAgICAgICB2YXIgb25lX3RpbWVzX3JlYWRhYmxlX29iaiA9IHdvcmtfdGltZXNfYXJyYXlbIG9ial9rZXkgXTtcclxuXHJcbiAgICAgICAgICAgIC8vICc0MzIwMF81MDQwMCdcclxuICAgICAgICAgICAgdmFyIHRpbWVfa2V5ID0gJycgKyBvbmVfdGltZXNfcmVhZGFibGVfb2JqWyAndGltZXNfYXNfc2Vjb25kcycgXVsgMCBdICsgJ18nICsgb25lX3RpbWVzX3JlYWRhYmxlX29ialsgJ3RpbWVzX2FzX3NlY29uZHMnIF1bIDEgXTtcclxuXHJcblxyXG4gICAgICAgICAgICAvKipcclxuICAgICAgICAgICAgICogIFsgICBcIjIwMjQtMDUtMTZcIjogWyAgMDogT2JqZWN0IHsgcmVzb3VyY2VfaWQ6IDIsICBpc19hdmFpbGFibGU6IHRydWUsIGJvb2tlZF9fc2Vjb25kczogW10sIOKApiB9XHJcbiAgICAgICAgICAgICAqICAgICAgICAgICAgICAgICAgICAgICAxOiBPYmplY3QgeyByZXNvdXJjZV9pZDogMTAsIGlzX2F2YWlsYWJsZTogdHJ1ZSwgYm9va2VkX19zZWNvbmRzOiBbXSwg4oCmIH1cclxuICAgICAgICAgICAgICogICAgICAgICAgICAgICAgICAgICAgIDI6IE9iamVjdCB7IHJlc291cmNlX2lkOiAxMSwgaXNfYXZhaWxhYmxlOiB0cnVlLCBib29rZWRfX3NlY29uZHM6IFtdLCDigKYgfVxyXG4gICAgICAgICAgICAgKiAgIF1cclxuICAgICAgICAgICAgICovXHJcbiAgICAgICAgICAgIHZhciBhdmFpbGFibGVfc2xvdHNfYnlfZGF0ZXMgPSB3cGJjX19nZXRfYXZhaWxhYmxlX3Nsb3RzX19mb3Jfc2VsZWN0ZWRfZGF0ZXNfdGltZXNfX2JsKCByZXNvdXJjZV9pZCwgd3BiY19jbG9uZV9vYmooIG9uZV90aW1lc19yZWFkYWJsZV9vYmpbICd0aW1lc19hc19zZWNvbmRzJyBdICkgKTtcclxuLy9jb25zb2xlLmxvZyggJ2F2YWlsYWJsZV9zbG90c19ieV9kYXRlcz09JyxhdmFpbGFibGVfc2xvdHNfYnlfZGF0ZXMpO1xyXG5cclxuICAgICAgICAgICAgLy8gTG9vcCBEYXRlc1xyXG4gICAgICAgICAgICBmb3IgKCB2YXIgZGF0ZV9zcWxfa2V5IGluIGF2YWlsYWJsZV9zbG90c19ieV9kYXRlcyApe1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBhdmFpbGFibGVfc2xvdHNfaW5fb25lX2RhdGUgPSBhdmFpbGFibGVfc2xvdHNfYnlfZGF0ZXNbIGRhdGVfc3FsX2tleSBdO1xyXG5cclxuICAgICAgICAgICAgICAgIHZhciBjb3VudF9hdmFpbGFibGVfc2xvdHMgPSAwXHJcblxyXG4gICAgICAgICAgICAgICAgdmFyIHRpbWUyYm9va19pbl9zZWNfcGVyX2VhY2hfZGF0ZSA9IHdwYmNfY2xvbmVfb2JqKCBvbmVfdGltZXNfcmVhZGFibGVfb2JqWyAndGltZXNfYXNfc2Vjb25kcycgXSApO1xyXG5cclxuICAgICAgICAgICAgICAgIC8vIExvb3AgQXZhaWxhYmxlIFNsb3RzIGluIERhdGVcclxuICAgICAgICAgICAgICAgIGZvciAoIHZhciBpID0gMDsgaSA8IGF2YWlsYWJsZV9zbG90c19pbl9vbmVfZGF0ZS5sZW5ndGg7IGkrKyApe1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICggYXZhaWxhYmxlX3Nsb3RzX2luX29uZV9kYXRlWyBpIF1bICdpc19hdmFpbGFibGUnIF0gKXtcclxuICAgICAgICAgICAgICAgICAgICAgICAgY291bnRfYXZhaWxhYmxlX3Nsb3RzKys7XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICAvLyBPdnZlcmlkZSB0aGF0ICB0aW1lIGJ5ICB0aW1lcywgIHRoYXQgIGNhbiAgYmUgZGlmZmVyZW50IGZvciBzZXZlcmFsICBkYXRlcywgIGlmIGRlYWN0aXZhdGVkIHRoaXMgb3B0aW9uOiAnVXNlIHNlbGVjdGVkIHRpbWVzIGZvciBlYWNoIGJvb2tpbmcgZGF0ZSdcclxuICAgICAgICAgICAgICAgICAgICAvLyBGb3IgZXhhbXBsZSBpZiBzbGVjdGUgdGltZSAxMDowMCAtIDExOjAwIGFuZCBzZWxlY3RlZCAzIGRhdGVzLCB0aGVuICBib29rZWQgdGltZXMgaGVyZSB3aWxsIGJlICAxMDowMCAtIDI0OjAwLCAgIDAwOjAwIC0gMjQ6MDAsICAgMDA6MDAgLSAxMTowMFxyXG4gICAgICAgICAgICAgICAgICAgIHRpbWUyYm9va19pbl9zZWNfcGVyX2VhY2hfZGF0ZSA9IHdwYmNfY2xvbmVfb2JqKCBhdmFpbGFibGVfc2xvdHNfaW5fb25lX2RhdGVbIGkgXVsndGltZV90b19ib29rX19zZWNvbmRzJ10gKTtcclxuICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAvLyBTYXZlIGluZm9cclxuICAgICAgICAgICAgICAgIGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiAoY2FwYWNpdHlfZGF0ZXNfdGltZXNbIGRhdGVfc3FsX2tleSBdKSApe1xyXG4gICAgICAgICAgICAgICAgICAgIGNhcGFjaXR5X2RhdGVzX3RpbWVzWyBkYXRlX3NxbF9rZXkgXSA9IFtdO1xyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIHZhciBjc3NfY2xhc3MgPSAnJztcclxuICAgICAgICAgICAgICAgIGlmICggc2VsZWN0ZWRfdGltZV9maWVsZHMubGVuZ3RoID4gMCApe1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICggICAoc2VsZWN0ZWRfdGltZV9maWVsZHNbIDAgXVsgJ3RpbWVzX2FzX3NlY29uZHMnIF1bIDAgXSA9PSB0aW1lMmJvb2tfaW5fc2VjX3Blcl9lYWNoX2RhdGVbIDAgXSlcclxuICAgICAgICAgICAgICAgICAgICAgICAgJiYgKHNlbGVjdGVkX3RpbWVfZmllbGRzWyAwIF1bICd0aW1lc19hc19zZWNvbmRzJyBdWyAxIF0gPT0gdGltZTJib29rX2luX3NlY19wZXJfZWFjaF9kYXRlWyAxIF0pICl7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNzc19jbGFzcyArPSAnIHdwYmNfc2VsZWN0ZWRfdGltZXNsb3QnXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgICAgIC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbiAgICAgICAgICAgICAgICAvLyBSZWFkYWJsZSBUaW1lIEZvcm1hdDogIDI0IHwgQU0vUE1cclxuICAgICAgICAgICAgICAgIC8vIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbiAgICAgICAgICAgICAgICB2YXIgcmVhZGFibGVfdGltZV9mb3JtYXQgPSB3cGJjX2pzX2NvbnZlcnRfX3NlY29uZHNfX3RvX19yZWFkYWJsZV90aW1lKCByZXNvdXJjZV9pZCwgdGltZTJib29rX2luX3NlY19wZXJfZWFjaF9kYXRlIClcclxuXHJcbiAgICAgICAgICAgICAgICBjYXBhY2l0eV9kYXRlc190aW1lc1sgZGF0ZV9zcWxfa2V5IF1bIHRpbWVfa2V5IF0gPSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gJ3ZhbHVlX29wdGlvbl8yNGgnOm9uZV90aW1lc19yZWFkYWJsZV9vYmpbICd2YWx1ZV9vcHRpb25fMjRoJyBdLFxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICdhdmFpbGFibGVfaXRlbXMnOiBjb3VudF9hdmFpbGFibGVfc2xvdHMsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJ3RpbWVzX2FzX3NlY29uZHMnOiB0aW1lMmJvb2tfaW5fc2VjX3Blcl9lYWNoX2RhdGUsXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJ2RhdGVfc3FsX2tleScgICAgOiBkYXRlX3NxbF9rZXksXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJ3JlYWRhYmxlX3RpbWUnICAgOiByZWFkYWJsZV90aW1lX2Zvcm1hdCxcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAnY3NzX2NsYXNzJyAgICAgICA6IGNzc19jbGFzc1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgcmV0dXJuIGNhcGFjaXR5X2RhdGVzX3RpbWVzO1xyXG5cclxuICAgIH1cclxuXHJcblxyXG5cclxuLy8gLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbi8vIFRlbXBsYXRlIGZvciBzaG9ydGNvZGUgaGludFxyXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXHJcbi8qKlxyXG4gKiBVcGRhdGUgdGltZSBoaW50IHNob3J0Y29kZSBjb250ZW50IGluIGJvb2tpbmcgZm9ybVxyXG4gKlxyXG4gKiBAcGFyYW0gcmVzb3VyY2VfaWRcclxuICovXHJcbmZ1bmN0aW9uIHdwYmNfdXBkYXRlX2NhcGFjaXR5X2hpbnQoIHJlc291cmNlX2lkICl7XHJcblxyXG4gICAgIC8qKlxyXG4gICAgICogIFsgICAgICAgICAgXCIyMDI0LTA1LTE3XCI6IFtcclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgMF84NjQwMCAgICA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIwMDowMCAtIDI0OjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE3XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDM2MDAwXzQzMjAwOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMTA6MDAgLSAxMjowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xN1wiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICA0MzIwMF81MDQwMDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjEyOjAwIC0gMTQ6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTdcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgNTA0MDBfNTc2MDA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIxNDowMCAtIDE2OjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE3XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDU3NjAwXzY0ODAwOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMTY6MDAgLSAxODowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xN1wiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICA2NDgwMF83MjAwMDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjE4OjAwIC0gMjA6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTdcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgIF1cclxuICAgICAqICAgICAgICAgICAgICBcIjIwMjQtMDUtMTlcIjogW1xyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAwXzg2NDAwICAgIDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjAwOjAwIC0gMjQ6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTlcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgMzYwMDBfNDMyMDA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIxMDowMCAtIDEyOjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE5XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDQzMjAwXzUwNDAwOiBPYmplY3QgeyBhdmFpbGFibGVfaXRlbXM6IDQsIHZhbHVlX29wdGlvbl8yNGg6IFwiMTI6MDAgLSAxNDowMFwiLCBkYXRlX3NxbF9rZXk6IFwiMjAyNC0wNS0xOVwiLCDigKYgfVxyXG4gICAgICogICAgICAgICAgICAgICAgICAgICAgICAgICAgICA1MDQwMF81NzYwMDogT2JqZWN0IHsgYXZhaWxhYmxlX2l0ZW1zOiA0LCB2YWx1ZV9vcHRpb25fMjRoOiBcIjE0OjAwIC0gMTY6MDBcIiwgZGF0ZV9zcWxfa2V5OiBcIjIwMjQtMDUtMTlcIiwg4oCmIH1cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgNTc2MDBfNjQ4MDA6IE9iamVjdCB7IGF2YWlsYWJsZV9pdGVtczogNCwgdmFsdWVfb3B0aW9uXzI0aDogXCIxNjowMCAtIDE4OjAwXCIsIGRhdGVfc3FsX2tleTogXCIyMDI0LTA1LTE5XCIsIOKApiB9XHJcbiAgICAgKiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDY0ODAwXzcyMDAwOiBPYmplY3QgeyBhdmFpbGEuLi5cclxuICAgICAqICAgICAgICAgICAgICAgICAgICAgICAgICAgIF1cclxuICAgICAqICAgICAgICAgIF1cclxuICAgICAqL1xyXG4gICAgdmFyIGF2YWlsYWJsZV9pdGVtc19hcnIgPSB3cGJjX2dldF9fYXZhaWxhYmxlX2l0ZW1zX2Zvcl9zZWxlY3RlZF9kYXRldGltZSggcmVzb3VyY2VfaWQgKTtcclxuXHJcbiAgICB2YXIgaXNfZnVsbF9kYXlfYm9va2luZyA9IHRydWU7XHJcbiAgICBmb3IgKCB2YXIgb2JqX2RhdGVfdGFnIGluIGF2YWlsYWJsZV9pdGVtc19hcnIgKXtcclxuXHJcbiAgICAgICAgaWYgKCBPYmplY3Qua2V5cyggYXZhaWxhYmxlX2l0ZW1zX2Fyclsgb2JqX2RhdGVfdGFnIF0gKS5sZW5ndGggPiAxICl7XHJcbiAgICAgICAgICAgIGlzX2Z1bGxfZGF5X2Jvb2tpbmcgPSBmYWxzZTtcclxuICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGZvciAoIHZhciB0aW1lX2tleSBpbiBhdmFpbGFibGVfaXRlbXNfYXJyWyBvYmpfZGF0ZV90YWcgXSApe1xyXG4gICAgICAgICAgICBpZiAoIChhdmFpbGFibGVfaXRlbXNfYXJyWyBvYmpfZGF0ZV90YWcgXVsgdGltZV9rZXkgXVsgJ3RpbWVzX2FzX3NlY29uZHMnIF1bIDAgXSA+IDApICYmIChhdmFpbGFibGVfaXRlbXNfYXJyWyBvYmpfZGF0ZV90YWcgXVsgdGltZV9rZXkgXVsgJ3RpbWVzX2FzX3NlY29uZHMnIF1bIDEgXSA8IDg2NDAwKSApe1xyXG4gICAgICAgICAgICAgICAgaXNfZnVsbF9kYXlfYm9va2luZyA9IGZhbHNlO1xyXG4gICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgICAgaWYgKCAhaXNfZnVsbF9kYXlfYm9va2luZyApe1xyXG4gICAgICAgICAgICBicmVhaztcclxuICAgICAgICB9XHJcbiAgICB9XHJcbiAgICB2YXIgY3NzX2lzX2Z1bGxfZGF5X2Jvb2tpbmcgPSAoaXNfZnVsbF9kYXlfYm9va2luZykgPyAnIHdwYmNfY2hpbnRfX2Z1bGxfZGF5X2Jvb2tpbmdzJyA6ICcnO1xyXG5cclxuICAgIHZhciB0b29sdGlwX2hpbnQgPSAnPGRpdiBjbGFzcz1cIndwYmNfY2FwYWNpdHlfaGludF9jb250YWluZXInICsgY3NzX2lzX2Z1bGxfZGF5X2Jvb2tpbmcgKyAnXCI+JztcclxuXHJcbiAgICBmb3IgKCB2YXIgb2JqX2RhdGVfdGFnIGluIGF2YWlsYWJsZV9pdGVtc19hcnIgKXtcclxuXHJcbiAgICAgICAgdmFyIHRpbWVzbG90c19pbl9kYXkgPSBhdmFpbGFibGVfaXRlbXNfYXJyWyBvYmpfZGF0ZV90YWcgXVxyXG5cclxuICAgICAgICB0b29sdGlwX2hpbnQgKz0gJzxkaXYgY2xhc3M9XCJ3cGJjX2NoaW50X19kYXRldGltZV9jb250YWluZXJcIj4nO1xyXG5cclxuICAgICAgICAvLyBKU09OLnN0cmluZ2lmeShhdmFpbGFibGVfaXRlbXNfYXJyKS5tYXRjaCgvW15cXFxcXVwiOi9nKS5sZW5ndGhcclxuICAgICAgICBpZiAoIChPYmplY3Qua2V5cyggYXZhaWxhYmxlX2l0ZW1zX2FyciApLmxlbmd0aCA+IDEpIHx8IChpc19mdWxsX2RheV9ib29raW5nKSApe1xyXG4gICAgICAgICAgICB0b29sdGlwX2hpbnQgKz0gJzxkaXYgY2xhc3M9XCJ3cGJjX2NoaW50X19kYXRlX2NvbnRhaW5lclwiPic7XHJcbiAgICAgICAgICAgICAgICB0b29sdGlwX2hpbnQgKz0gJzxkaXYgY2xhc3M9XCJ3cGJjX2NoaW50X19kYXRlXCI+JyArIG9ial9kYXRlX3RhZyArICc8L2Rpdj4gJztcclxuICAgICAgICAgICAgICAgIHRvb2x0aXBfaGludCArPSAnPGRpdiBjbGFzcz1cIndwYmNfY2hpbnRfX2RhdGVfZGl2aWRlclwiPjo8L2Rpdj4gJztcclxuICAgICAgICAgICAgdG9vbHRpcF9oaW50ICs9ICc8L2Rpdj4gJztcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGZvciAoIHZhciB0aW1lX2tleSBpbiB0aW1lc2xvdHNfaW5fZGF5ICl7XHJcbiAgICAgICAgICAgICAgICB0b29sdGlwX2hpbnQgKz0gJzxkaXYgY2xhc3M9XCJ3cGJjX2NoaW50X190aW1lX2NvbnRhaW5lclwiPic7XHJcblxyXG4gICAgICAgICAgICAgICAgLy8gSWYgbm90IGZ1bGwgZGF5IGJvb2tpbmc6IGUuZyAgMDA6MDAgLSAyNDowMFxyXG4gICAgICAgICAgICAgICAgLy9pZiAoICh0aW1lc2xvdHNfaW5fZGF5WyB0aW1lX2tleSBdWyAndGltZXNfYXNfc2Vjb25kcycgXVsgMCBdID4gMCkgJiYgKHRpbWVzbG90c19pbl9kYXlbIHRpbWVfa2V5IF1bICd0aW1lc19hc19zZWNvbmRzJyBdWyAxIF0gPCA4NjQwMCkgKXtcclxuXHJcbiAgICAgICAgICAgICAgICAgICAgIHRvb2x0aXBfaGludCArPSAnPGRpdiBjbGFzcz1cIndwYmNfY2hpbnRfX3RpbWVzbG90ICcgKyB0aW1lc2xvdHNfaW5fZGF5WyB0aW1lX2tleSBdWyAnY3NzX2NsYXNzJyBdICsgJ1wiPidcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICsgdGltZXNsb3RzX2luX2RheVsgdGltZV9rZXkgXVsgJ3JlYWRhYmxlX3RpbWUnIF1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICArICc8L2Rpdj4gJztcclxuICAgICAgICAgICAgICAgICAgICB0b29sdGlwX2hpbnQgKz0gJzxkaXYgY2xhc3M9XCJ3cGJjX2NoaW50X190aW1lc2xvdF9kaXZpZGVyXCI+OiA8L2Rpdj4gJztcclxuICAgICAgICAgICAgICAgIC8vfVxyXG5cclxuICAgICAgICAgICAgICAgICAgICB0b29sdGlwX2hpbnQgKz0gJzxkaXYgY2xhc3M9XCJ3cGJjX2NoaW50X19hdmFpbGFiaWxpdHkgYXZhaWxhYmlsaXR5X251bV8nICsgdGltZXNsb3RzX2luX2RheVsgdGltZV9rZXkgXVsgJ2F2YWlsYWJsZV9pdGVtcycgXSArICdcIj4nXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICArIHRpbWVzbG90c19pbl9kYXlbIHRpbWVfa2V5IF1bICdhdmFpbGFibGVfaXRlbXMnIF1cclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICsgJzwvZGl2PiAnO1xyXG4gICAgICAgICAgICAgICAgdG9vbHRpcF9oaW50ICs9ICc8L2Rpdj4gJztcclxuICAgICAgICB9XHJcbiAgICAgICAgdG9vbHRpcF9oaW50ICs9ICc8L2Rpdj4gJztcclxuICAgIH1cclxuXHJcbiAgICB0b29sdGlwX2hpbnQgKz0gJzwvZGl2PiAnO1xyXG5cclxuXHJcbi8vY29uc29sZS5sb2coICc6OiBhdmFpbGFibGVfaXRlbXNfYXJyIDo6JywgYXZhaWxhYmxlX2l0ZW1zX2FyciApO1xyXG5cclxuXHJcbiAgICBqUXVlcnkoICcuY2FwYWNpdHlfaGludF8nICsgcmVzb3VyY2VfaWQgKS5odG1sKCB0b29sdGlwX2hpbnQgKTtcclxuXHJcbiAgICBqUXVlcnkoICcuY2FwYWNpdHlfaGludF8nICsgcmVzb3VyY2VfaWQgKS5yZW1vdmVDbGFzcyggJ3dwYmNfY2hpbl9uZXdsaW5lJyApO1xyXG4gICAgaWYgKCBPYmplY3Qua2V5cyggYXZhaWxhYmxlX2l0ZW1zX2FyciApLmxlbmd0aCA+IDEgKXtcclxuICAgICAgICBqUXVlcnkoICcuY2FwYWNpdHlfaGludF8nICsgcmVzb3VyY2VfaWQgKS5hZGRDbGFzcyggJ3dwYmNfY2hpbl9uZXdsaW5lJyApO1xyXG4gICAgfVxyXG59XHJcblxyXG5cclxuICAgIC8vIFJ1biBzaG9ydGNvZGUgY2hhbmdpbmcgYWZ0ZXIgIGRhdGVzIHNlbGVjdGlvbiwgIGFuZCBvcHRpb25zIHNlbGVjdGlvbi5cclxuICAgIGpRdWVyeSggZG9jdW1lbnQgKS5yZWFkeSggZnVuY3Rpb24gKCl7XHJcbiAgICAgICAgalF1ZXJ5KCAnLmJvb2tpbmdfZm9ybV9kaXYnICkub24oICd3cGJjX2Jvb2tpbmdfZGF0ZV9vcl9vcHRpb25fc2VsZWN0ZWQnLCBmdW5jdGlvbiAoIGV2ZW50LCByZXNvdXJjZV9pZCApe1xyXG4gICAgICAgICAgICB3cGJjX3VwZGF0ZV9jYXBhY2l0eV9o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
