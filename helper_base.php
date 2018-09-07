<?php

/**
 * Indicia, the OPAL Online Recording Toolkit.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/gpl.html.
 *
 * @author Indicia Team
 * @license http://www.gnu.org/licenses/gpl.html GPL 3.0
 * @link https://github.com/indicia-team/warehouse/
 */

if (file_exists(dirname(__FILE__) . '/helper_config.php')) {
  require_once 'helper_config.php';
}
require_once 'lang.php';
require_once 'libcurlEmulator/libcurlemu.inc.php';

global $indicia_templates;

/**
 * Provides control templates to define the output of the data entry helper class.
 */
$indicia_templates = array(
  'blank' => '',
  'prefix' => '',
  'controlWrap' => "<div id=\"ctrl-wrap-{id}\" class=\"form-row ctrl-wrap\">{control}</div>\n",
  'controlWrapErrorClass' => '',
  // Template for control with associated buttons/icons to appear to the side.
  'controlAddonsWrap' => "{control}{addons}",
  'justControl' => "{control}\n",
  'jsWrap' => "<script type=\"text/javascript\">\n/* <![CDATA[ */\n" .
      "document.write('{content}');" .
      "/* ]]> */</script>\n",
  'label' => '<label for="{id}"{labelClass}>{label}:</label>',
  // Use if label ends with another punctuation mark.
  'labelNoColon' => '<label for="{id}"{labelClass}>{label}</label>',
  'labelAfter' => '<label for="{id}"{labelClass}>{label}</label>', // no colon
  'toplabel' => '<label data-for="{id}"{labelClass}>{label}:</label>',
  'toplabelNoColon' => '<label data-for="{id}"{labelClass}>{label}</label>',
  'suffix' => "\n",
  'requiredsuffix' => "<span class=\"deh-required\">*</span>",
  'button' => '<button id="{id}" type="button" title="{title}"{class}>{caption}</button>',
  // Button classes. If changing these, keep the indicia-button class to ensure functionality works.
  'buttonDefaultClass' => 'indicia-button',
  'buttonHighlightedClass' => 'indicia-button',
  'buttonWarningClass' => 'indicia-button',
    // Classes applied to <a> when styled like a button
  'anchorButtonClass' => 'ui-state-default ui-corner-all indicia-button',
  'submitButton' => '<input id="{id}" type="submit"{class} name="{name}" value="{caption}" />',
  // Message boxes
  'messageBox' => '<div class="page-notice ui-state-highlight ui-corner-all">{message}</div>',
  // Lock icons.
  'lock_icon' => '<span id="{id}_lock" class="unset-lock">&nbsp;</span>',
  'lock_javascript' => "indicia.locks.initControls (
      \"".lang::get('locked tool-tip')."\",
      \"".lang::get('unlocked tool-tip')."\",
      \"{lock_form_mode}\"
      );\n",
  'validation_message' => '<p class="{class}">{error}</p>'."\n",
  'validation_icon' => '<span class="ui-state-error ui-corner-all validation-icon">'.
      '<span class="ui-icon ui-icon-alert"></span></span>',
  'error_class' => 'inline-error',
  'invalid_handler_javascript' => "function(form, validator) {
          var tabselected=false;
          jQuery.each(validator.errorMap, function(ctrlId, error) {
            // select the tab containing the first error control
            var ctrl = jQuery('[name=' + ctrlId.replace(/:/g, '\\\\:').replace(/\[/g, '\\\\[').replace(/\\]/g, '\\\\]') + ']');
            if (!tabselected) {
              var tp=ctrl.filter('input,select,textarea').closest('.ui-tabs-panel');
              if (tp.length===1) {
                indiciaFns.activeTab($(tp).parent(), tp.id);
              }
              tabselected = true;
            }
            ctrl.parents('fieldset').removeClass('collapsed');
            ctrl.parents('.fieldset-wrapper').show();
          });
        }",
  'image_upload' => '<input type="file" id="{id}" name="{fieldname}" accept="image/*" {title}/>' . "\n" .
      '<input type="hidden" id="{pathFieldName}" name="{pathFieldName}" value="{pathFieldValue}"/>' . "\n",
  'text_input' => '<input type="text" id="{id}" name="{fieldname}"{class} {attributes} value="{default}" {title} {maxlength} />'."\n",
  'hidden_text' => '<input type="hidden" id="{id}" name="{fieldname}"{class} {attributes} value="{default}" />',
  'password_input' => '<input type="password" id="{id}" name="{fieldname}"{class} {attributes} value="{default}" {title} />'."\n",
  'textarea' => '<textarea id="{id}" name="{fieldname}"{class} {attributes} cols="{cols}" rows="{rows}" {title}>{default}</textarea>'."\n",
  'checkbox' => '<input type="hidden" name="{fieldname}" value="0"/><input type="checkbox" id="{id}" name="{fieldname}"{class} {attributes} value="1"{checked} {title} />'."\n",
  'training' => '<input type="hidden" name="{fieldname}" value="{hiddenValue}"/><input type="checkbox" id="{id}" name="{fieldname}" {class} {attributes} value="1"{checked} {title} />'."\n",
  'date_picker' => '<input type="text" id="{id}" name="{fieldname}"{class} {attributes} placeholder="{placeholder}" size="30" value="{default}" {title}/>'."\n",
  'select' => '<select id="{id}" name="{fieldname}"{class} {attributes} {title}>{items}</select>',
  'select_item' => '<option value="{value}" {selected} >{caption}</option>',
  'select_species' => '<option value="{value}" {selected} >{caption} - {common}</option>',
  'listbox' => '<select id="{id}" name="{fieldname}"{class} {attributes} size="{size}" multiple="{multiple}" {title}>{items}</select>',
  'listbox_item' => '<option value="{value}"{selected} >{caption}</option>',
  'list_in_template' => '<ul{class} {title}>{items}</ul>',
  'check_or_radio_group' => '<ul {class} id="{id}">{items}</ul>',
  'check_or_radio_group_item' => '<li><input type="{type}" name="{fieldname}" id="{itemId}" value="{value}"{class}{checked}{title} {disabled}/><label for="{itemId}">{caption}</label></li>',
  'map_panel' => "<div id=\"{divId}\" style=\"width: {width}; height: {height};\"{class}></div>",
  'georeference_lookup' => "<script type=\"text/javascript\">\n/* <![CDATA[ */\n".
    "document.write('<input type=\"text\" id=\"imp-georef-search\"{class} />{searchButton}');\n".
    "document.write('<div id=\"imp-georef-div\" class=\"ui-corner-all ui-widget-content ui-helper-hidden\">');\n".
    "document.write('  <div id=\"imp-georef-output-div\">');\n".
    "document.write('  </div>  {closeButton}');\n".
    "document.write('</div>');".
    "\n/* ]]> */</script>",
  'tab_header' => "<ul>{tabs}</ul>\n",
  'taxon_label' => '<div class="biota"><span class="nobreak sci binomial"><em class="taxon-name">{taxon}</em></span> {authority} '.
      '<span class="nobreak vernacular">{default_common_name}</span></div>',
  'single_species_taxon_label' => '{taxon}',
  'treeview_node' => '<span>{caption}</span>',
  'tree_browser' => '<div{outerClass} id="{divId}"></div><input type="hidden" name="{fieldname}" id="{id}" value="{default}"{class}/>',
  'tree_browser_node' => '<span>{caption}</span>',
  'autocomplete' => '<input id="{inputId}" name="{inputId}" type="text" value="{defaultCaption}" {class} {disabled} {title}/>' . "\n",
  'autocomplete_javascript' => "$('input#{escaped_input_id}').indiciaAutocomplete({
    id: '{id}',
    fieldname: '{fieldname}',
    baseUrl: '{url}',
    extraParams: {extraParams},
    captionField: '{captionField}',
    valueField: '{valueField}',
    default: '{default}',
    defaultCaption: '{defaultCaption}',
    mode: '{mode}',
    formatOptions: {formatOptions}
  });\n",
  'sub_list' => '<div id="{id}:box" class="control-box wide"><div>'."\n".
    '<div>'."\n".
    '{panel_control} <input id="{id}:add" type="button" value="'.lang::get('add').'" />'."\n".
    '</div>'."\n".
    '<ul id="{id}:sublist" class="ind-sub-list">{items}</ul>{subListAdd}'."\n".
    '</div></div>'."\n",
  'sub_list_add' => "\n".'<input type="hidden"  id="{id}:addToTable" name="{mainEntity}:insert_captions_use" value="{basefieldname}" />'.
    '<input type="hidden" name="{mainEntity}:insert_captions_to_create" value="{table}" />',
  'sub_list_item' => '<li class="ui-widget-content ui-corner-all"><span class="ind-delete-icon">&nbsp;</span>{caption}'.
    '<input type="hidden" name="{fieldname}" value="{value}" /></li>',
  'linked_list_javascript' => '
{fn} = function() {
var placeHolder=" Loading... ";
  $("#{escapedId}").addClass("ui-state-disabled").html("<option>"+placeHolder+"</option>");
  if ($(this).val() != placeHolder) { // skip loading for placeholder text
    $.getJSON("{request}&{query}", function(data){
      var $control = $("#{escapedId}"), selected;
      $control.html("");
      if (data.length>0) {
        $control.removeClass("ui-state-disabled");
        if (data.length>1) {
          $control.append("<option>&lt;Please select&gt;</option>");
        }
        $.each(data, function(i) {
          selected = typeof indiciaData["default{escapedId}"]!=="undefined" && indiciaData["default{escapedId}"]==this.{valueField} ? \'" selected="selected\' : "";
          $control.append("<option value=\"" + this.{valueField} + selected + "\">" + this.{captionField} + "</option>");
        });
      } else {
        $control.html("<option>{instruct}</option>");
      }
      $control.change();
    });
  }
};
$("#{parentControlId}").bind("change.indicia", {fn});
if ($("#{escapedId} option").length===0) {
  $("#{parentControlId}").trigger("change.indicia");
}'."\n",

  'postcode_textbox' => '<input type="text" name="{fieldname}" id="{id}"{class} value="{default}" '.
        'onblur="javascript:indiciaFns.decodePostcode(\'{linkedAddressBoxId}\');" />'."\n",
  'sref_textbox' => '<input type="text" id="{id}" name="{fieldname}" {class} {disabled} value="{default}" />' .
        '<input type="hidden" id="{geomid}" name="{geomFieldname}" value="{defaultGeom}" />'."\n",
  'sref_textbox_latlong' => '<label for="{idLat}">{labelLat}:</label>'.
        '<input type="text" id="{idLat}" name="{fieldnameLat}" {class} {disabled} value="{defaultLat}" /><br />' .
        '<label for="{idLong}">{labelLong}:</label>'.
        '<input type="text" id="{idLong}" name="{fieldnameLong}" {class} {disabled} value="{defaultLong}" />' .
        '<input type="hidden" id="{geomid}" name="geomFieldname" value="{defaultGeom}" />'.
        '<input type="hidden" id="{id}" name="{fieldname}" value="{default}" />',
  'attribute_cell' => "\n<td class=\"scOccAttrCell ui-widget-content {class}\" headers=\"{headers}\">{content}</td>",
  'taxon_label_cell' => "\n<td class=\"scTaxonCell{editClass}\" headers=\"{tableId}-species-{idx}\" {colspan}>{content}</td>",
  'helpText' => "\n<p class=\"{helpTextClass}\">{helpText}</p>",
  'file_box' => '',                   // the JQuery plugin default will apply, this is just a placeholder for template overrides.
  'file_box_initial_file_info' => '', // the JQuery plugin default will apply, this is just a placeholder for template overrides.
  'file_box_uploaded_image' => '',    // the JQuery plugin default will apply, this is just a placeholder for template overrides.
  'paging_container' => "<div class=\"pager ui-helper-clearfix\">\n{paging}\n</div>\n",
  'paging' => '<div class="left">{first} {prev} {pagelist} {next} {last}</div><div class="right">{showing}</div>',
  'jsonwidget' => '<div id="{id}" {class}></div>',
  'report_picker' => '<div id="{id}" {class}>{reports}<div class="report-metadata"></div><button type="button" id="picker-more">{moreinfo}</button><div class="ui-helper-clearfix"></div></div>',
  'report_download_link' => '<div class="report-download-link"><a href="{link}">{caption}</a></div>',
  'verification_panel' => '<div id="verification-panel">{button}<div class="messages" style="display: none"></div></div>',
  'two-col-50' => '<div class="two columns"><div class="column">{col-1}</div><div class="column">{col-2}</div></div>',
  'loading_overlay' => '<div class="loading-overlay"></div>',
  'report-table' => '<table{class}>{content}</table>',
  'report-thead' => '<thead{class}>{content}</thead>',
  'report-thead-tr' => '<tr{class}{title}>{content}</tr>',
  'report-thead-th' => '<th>{content}</th>',
  'report-tbody' => '<tbody>{content}</tbody>',
  'report-tbody-tr' => '<tr{class}{rowId}{rowTitle}>{content}</tr>',
  'report-tbody-td' => '<td{class}>{content}</td>',
  'report-action-button' => '<a{class}{href}{onclick}>{content}</a>',
  'data-input-table' => '<table{class}{id}>{content}</table>',
  'review_input' => '<div{class}{id}><div{headerClass}{headerId}>{caption}</div>
<div id="review-map-container"></div>
<div{contentClass}{contentId}></div>
</div>'
);


/**
 * Base class for the report and data entry helpers. Provides several generally useful methods and also includes
 * resource management.
 * @package Client
 */
class helper_base {

  /*
   * Variables that can be specified in helper_config.php, or should be set by
   * the host system.
   */

  /**
   * Base URL of the warehouse we are linked to.
   *
   * @var string
   */
  public static $base_url = '';

  /**
   * Path to proxy script for calls to the warehouse.
   *
   * Allows the warehouse to sit behind a firewall only accessible from the
   * server.
   *
   * @var string
   */
  public static $warehouse_proxy = NULL;

  /**
   * Base URL of the GeoServer we are linked to if GeoServer is used.
   *
   * @var string
   */
  public static $geoserver_url = '';

  /**
   * A temporary location for uploaded images.
   *
   * Images are stored here when uploaded by a recording form but before they
   * are sent to the warehouse.
   *
   * @var string
   */
  public static $interim_image_folder;

  /**
   * Google API key for place searches.
   *
   * @var string
   */
  public static $google_api_key = '';

  /**
   * Google Maps JavaScript API key.
   *
   * @var string
   */
  public static $google_maps_api_key = '';

  /**
   * Bing Maps API key.
   *
   * @var string
   */
  public static $bing_api_key = '';

  /**
   * Ordnance Survey Maps API key.
   *
   * @var string
   */
  public static $os_api_key = '';

  /**
   * Setting which allows the host site (e.g. Drupal) handle translation.
   *
   * For example, when TRUE, a call to lang::get() is delegated to Drupal's t()
   * function.
   *
   * @var bool
   */
  public static $delegate_translation_to_hostsite = FALSE;

  /*
   * End of ariables that can be specified in helper_config.php.
   */

  /**
   * @var boolean Flag set to true if returning content for an AJAX request. This allows the javascript to be returned
   * direct rather than embedding in document.ready and window.onload handlers.
   */
  public static $is_ajax = false;

  /**
   * @var integer Website ID, stored here to assist with caching.
   */
  public static $website_id = null;

  /**
   * @var Array List of resources that have been identified as required by the
   * controls used. This defines the JavaScript and stylesheets that must be
   * added to the page. Each entry is an array containing stylesheets and
   * javascript sub-arrays. This has public access so the Drupal module can
   * perform Drupal specific resource output.
   */
  public static $required_resources=array();

  /**
   * @var Array List of all available resources known. Each resource is named, and contains a sub array of
   * deps (dependencies), stylesheets and javascripts.
   */
  public static $resource_list=null;

  /**
   * Any control that wants to access the read authorisation tokens from JavaScript can set them here. They will then
   * be available from indiciaData.auth.read.
   * @var Array
   */
  public static $js_read_tokens=null;

  /**
   * @var string Path to Indicia JavaScript folder. If not specified, then it is
   * calculated from the Warehouse $base_url.
   * This path should be a full path on the server (starting with '/' exluding
   * the domain and ending with '/').
   */
  public static $js_path = null;

  /**
   * @var string Path to Indicia CSS folder. If not specified, then it is calculated from the Warehouse $base_url.
   * This path should be a full path on the server (starting with '/' exluding the domain).
   */
  public static $css_path = null;

  /**
   * @var string Path to Indicia Images folder.
   */
  public static $images_path = null;

  /**
   * @var string Path to Indicia cache folder. Defaults to client_helpers/cache.
   */
  public static $cache_folder = false;

  /**
   * @var array List of resources that have already been dumped out, so we don't duplicate them. For example, if the
   * site template includes JQuery set $dumped_resources[]='jquery'.
   */
  public static $dumped_resources=array();

  /**
   * @var string JavaScript text to be emitted after the data entry form. Each control that
   * needs custom JavaScript can append the script to this variable.
   */
  public static $javascript = '';

  /**
   * @var string JavaScript text to be emitted after the data entry form and all other JavaScript.
   */
  public static $late_javascript = '';

  /**
   * @var string JavaScript text to be emitted during window.onload.
   */
  public static $onload_javascript = '';

  /**
   * @var boolean Setting to completely disable loading from the cache
   */
  public static $nocache = false;

 /**
  * @var integer On average, every 1 in $interim_image_chance_purge times the
  * Warehouse is called for data, all interim images older than $interim_image_expiry
  * seconds will be deleted. These are images that should have uploaded to the
  * warehouse but the form was not finally submitted.
  */
  public static $interim_image_chance_purge = 100;

  /**
   * @var integer On average, every 1 in $cache_chance_expire times the Warehouse
   * is called for data which is
   */
  public static $interim_image_expiry = 14400;

  /**
   * @var array Contains elements for each media type that can be uploaded. Each
   * element is an array of allowed file extensions for that media type. Used
   * for filtering files to upload on client side. File extensions must be in
   * lower case. Each entry should have its mime type included in
   * $upload_mime_types.
   */
  public static $upload_file_types = array(
    'image' => array('jpg', 'gif', 'png', 'jpeg'),
    'pdf' => array('pdf'),
    'audio' => array('mp3', 'wav')
  );

  /**
   * @var array Contains elements for each media type that can be uploaded. Each
   * element is an array of the allowed mime subtypes for that media type. Used
   * for testing uploaded files. Each entry in $upload_file_types should have
   * its mime type in this list.
   */
  public static $upload_mime_types = array(
    'image' => array('jpeg', 'gif', 'png'),
    'application' => array('pdf'),
    'audio' => array('mpeg', 'x-wav')
  );

  /**
   * List of methods used to report a validation failure.
   *
   * Options are message, message, hint, icon, colour, inline. The inline option specifies that the
   * message should appear on the same line as the control. Otherwise it goes on the next line,
   * indented by the label width. Because in many cases, controls on an Indicia form occupy the
   * full available width, it is often more appropriate to place error messages on the next line
   * so this is the default behaviour.
   *
   * @var array
   */
  public static $validation_mode = array('message', 'colour');

  /**
   * Name of the form which has been set up for jQuery validation, if any.
   *
   * @var array
   */
  public static $validated_form_id = null;

  /**
   * Helptext positioning.
   *
   * Determines where the information is displayed when helpText is defined for a control.
   * Options are before, after.
   *
   * @var string
   */
  public static $helpTextPos = 'after';

  /**
   * Form Mode. Initially unset indicating new input, but can be set to ERRORS or RELOAD.
   *
   * @var string
   */
  public static $form_mode = NULL;

  /**
   * List of all error messages returned from an attempt to save.
   *
   * @var array
   */
  public static $validation_errors = NULL;

  /**
   * @var Array of default validation rules to apply to the controls on the form if the
   * built in client side validation is used (with the jQuery validation plugin). This array
   * can be replaced if required.
   * @todo This array could be auto-populated with validation rules for a survey's fields from the
   * Warehouse.
   */
  public static $default_validation_rules = array(
    'sample:date' => array('required', 'date'),
    'sample:entered_sref' => array('required'),
    'occurrence:taxa_taxon_list_id' => array('required'),
    'location:name' => array('required'),
    'location:centroid_sref' => array('required'),
  );

  /**
   * List of messages defined to pass to the validation plugin.
   *
   * @var array
   */
  public static $validation_messages = array();


  /**
   * Length of time in seconds after which cached Warehouse responses will start to expire.
   *
   * @var int
   */
  public static $cache_timeout = 3600;

  /**
   * Chance of refreshing a cache file.
   *
   * On average, every 1 in $cache_chance_expire times the Warehouse is called for data which is
   * cached but older than the cache timeout, the cached data will be refreshed. This introduces a random element to
   * cache refreshes so that no single form load event is responsible for refreshing all cached content.
   *
   * @var int
   */
  public static $cache_chance_refresh_file = 10;

  /**
   * Chance of purging the cache.
   *
   * On average, every 1 in $cache_chance_purge times the Warehouse is called for data, all files
   * older than 5 times the cache_timeout will be purged, apart from the most recent $cache_allowed_file_count files.
   *
   * @var int
   */
  public static $cache_chance_purge = 100;

  /**
   * Files allowed in cache.
   *
   * Number of recent files allowed in the cache which the cache will not bother clearing during a deletion operation.
   * They will be refreshed occasionally when requested anyway.
   *
   * @var int
   */
  public static $cache_allowed_file_count = 50;

  /**
   * A place to keep data and settings for Indicia code, to avoid using globals.
   *
   * @var array
   */
  public static $data = array();

  /*
   * Global format for display of dates such as sample date, date attributes in Drupal.
   * Note this only affects the loading of the date itself when a form in edit mode loads, the format displayed as soon as the
   * date picker is selected is determined by Drupal's settings. So make sure Drupal's date format and this option match up.
   * @todo Need to create a proper config option for this.
   * @todo Need to ensure this setting is utilised every where it should be.
   *
   * @var string
   *
   */
  public static $date_format = 'd/m/Y';

  /**
   * Indicates if any form controls have specified the lockable option.
   *
   * If any form controls have specified the lockable option we will need to output some javascript.
   *
   * @var bool
   */
  protected static $using_locking = FALSE;

  /**
   * Are we linking in the default stylesheet? Handled sligtly different to the others so it can be added to the end of the
   * list, allowing our CSS to override other stuff.
   *
   * @var bool
   */
  protected static $default_styles = FALSE;

  /**
   * Array of html attributes. When replacing items in a template, these get automatically wrapped. E.g.
   * a template replacement for the class will be converted to class="value". The key is the parameter name,
   * and the value is the html attribute it will be wrapped into.
   */
  protected static $html_attributes = array(
    'class' => 'class',
    'outerClass' => 'class',
    'selected' => 'selected'
  );

  /**
   * List of error messages that have been displayed.
   *
   * Ensures we don't duplicate them when dumping any remaining ones at the end.
   *
   * @var array
   */
  protected static $displayed_errors = array();

  /**
   * Track if we have already output the indiciaFunctions.
   *
   * @var bool
   */
  protected static $indiciaFnsDone = FALSE;

  /**
   * Returns the URL to access the warehouse by, respecting proxy settings.
   *
   * @return string
   */
  public static function getProxiedBaseUrl() {
    return empty(self::$warehouse_proxy) ? self::$base_url : self::$warehouse_proxy;
  }

  /**
   * Returns the folder to store uploaded images in before submission.
   *
   * When an image has been uploaded on a form but not submitted to the
   * warehouse, it is stored in this folder location temporarily.
   *
   * @param string $mode
   *   Set to one of these options:
   *   * fullpath - full path from root of the server disk.
   *   * domain - path from the root of the domain.
   *   * relative - path relative to the current script location (default)
   *
   * @return string
   *   The folder location.
   */
  public static function getInterimImageFolder($mode = 'relative') {
    $folder = isset(self::$interim_image_folder)
      ? self::$interim_image_folder
      : self::client_helper_path() . 'upload/';
    switch ($mode) {
      case 'fullpath':
        return getcwd() . '/' . $folder;

      case 'domain':
        return self::getRootFolder() . $folder;

      default:
        return $folder;
    }
  }

  /**
   * Utility function to insert a list of translated text items for use in JavaScript.
   *
   * @param string $group
   *   Name given to the group of language strings for organisational purposes.
   * @param array $strings
   *   Associative array of keys and texts to translate.
   */
  public static function addLanguageStringsToJs($group, array $strings) {
      self::$javascript .= <<<JS
if (typeof indiciaData.lang === "undefined") {
  indiciaData.lang = {};
}
indiciaData.lang.$group = {};

JS;
    foreach ($strings as $key => $text) {
        self::$javascript .= "indiciaData.lang.$group.$key = '" .
        str_replace("'", "\'", lang::get($text)) . "';\n";
    }
  }

  /**
   * Method to link up the external css or js files associated with a set of code.
   * This is normally called internally by the control methods to ensure the required
   * files are linked into the page so does not need to be called directly. However
   * it can be useful when writing custom code that uses one of these standard
   * libraries such as jQuery.
   * Ensures each file is only linked once and that dependencies are included
   * first and in the order given.
   *
   * @param string $resource
   *   Name of resource to link. The following options are available:
   *   * indiciaFns
   *   * jquery
   *   * openlayers
   *   * graticule
   *   * clearLayer
   *   * addrowtogrid
   *   * speciesFilterPopup
   *   * indiciaMapPanel
   *   * indiciaMapEdit
   *   * postcode_search
   *   * locationFinder
   *   * createPersonalSites
   *   * autocomplete
   *   * indicia_locks
   *   * jquery_cookie
   *   * jquery_ui
   *   * jquery_ui_fr
   *   * jquery_form
   *   * json
   *   * reportPicker
   *   * treeview
   *   * treeview_async
   *   * googlemaps
   *   * multimap
   *   * virtualearth
   *   * fancybox
   *   * treeBrowser
   *   * defaultStylesheet
   *   * validation
   *   * plupload
   *   * jqplot
   *   * jqplot_bar
   *   * jqplot_pie
   *   * jqplot_category_axis_renderer
   *   * jqplot_canvas_axis_label_renderer
   *   * jqplot_trendline
   *   * reportgrid
   *   * tabs
   *   * wizardprogress
   *   * spatialReports
   *   * jsonwidget
   *   * timeentry
   *   * verification
   *   * complexAttrGrid
   *   * footable
   *   * indiciaFootableReport
   *   * indiciaFootableChecklist
   *   * html2pdf
   *   * review_input
   *   * sub_list
   *   * georeference_default_geoportal_lu
   *   * georeference_defaultgoogle_places
   *   * georeference_default_indicia_locations
   *   * sref_handlers_4326
   *   * sref_handlers_osgb
   *   * sref_handlers_osie
   */
  public static function add_resource($resource) {

    // Ensure indiciaFns is always the first resource added
    if (!self::$indiciaFnsDone) {
      self::$indiciaFnsDone = true;
      self::add_resource('indiciaFns');
    }
    $resourceList = self::get_resources();
    // If this is an available resource and we have not already included it, then add it to the list
    if (array_key_exists($resource, $resourceList) && !in_array($resource, self::$required_resources)) {
      if (isset($resourceList[$resource]['deps'])) {
        foreach ($resourceList[$resource]['deps'] as $dep) {
          self::add_resource($dep);
        }
      }
      self::$required_resources[] = $resource;
    }
  }

  /**
   * Utility method to ensure trailing slash on a path.
   *
   * @param string $path
   *   The path.
   * @return string
   *   The path with trailing slash added if required.
   */
  private static function ensureTrailingSlash($path) {
    return substr($path, -1) === '/' ? $path : "/$path";
  }

  /**
   * List of external resources including stylesheets and js files used by the data entry helper class.
   */
  public static function get_resources() {
    if (self::$resource_list === NULL) {
      $base = self::ensureTrailingSlash(parent::$base_url);
      self::$js_path = empty(self::$js_path) ? "{$base}media/js/" : self::ensureTrailingSlash(self::$js_path);
      self::$css_path = empty(self::$css_path) ? "{$base}media/css/" : self::ensureTrailingSlash(self::$css_path);
      self::$images_path = empty(self::$images_path) ? "{$base}media/images/" : self::ensureTrailingSlash(self::$images_path);
      global $indicia_theme, $indicia_theme_path;
      if (!isset($indicia_theme)) {
        // Use default theme if page does not specify it's own.
        $indicia_theme = "default";
      }
      if (!isset($indicia_theme_path)) {
        // Use default theme path if page does not specify it's own.
        $indicia_theme_path = preg_replace('/css\/$/', 'themes/', self::$css_path);
      }
      // Ensure a trailing path.
      if (substr($indicia_theme_path, -1) !== '/')
        $indicia_theme_path .= '/';
      $protocol = empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off' ? 'http' : 'https';
      self::$resource_list = array (
        'indiciaFns' => array('deps' => array('jquery'), 'javascript' => array(self::$js_path . "indicia.functions.js")),
        'jquery' => array('javascript' => array(self::$js_path."jquery.js", self::$js_path . "ie_vml_sizzlepatch_2.js")),
        'openlayers' => array('javascript' => array(self::$js_path.(function_exists('iform_openlayers_get_file') ? iform_openlayers_get_file() : "OpenLayers.js"),
            self::$js_path."proj4js.js", self::$js_path."proj4defs.js", self::$js_path."lang/en.js")),
        'graticule' => array('deps' => array('openlayers'), 'javascript' => array(self::$js_path."indiciaGraticule.js")),
        'clearLayer' => array('deps' => array('openlayers'), 'javascript' => array(self::$js_path."clearLayer.js")),
        'hoverControl' => array('deps' =>array('openlayers'), 'javascript' => array(self::$js_path."hoverControl.js")),
        'addrowtogrid' => array('deps' => array('validation'), 'javascript' => array(self::$js_path."addRowToGrid.js")),
        'speciesFilterPopup' => array('deps' => array('addrowtogrid'), 'javascript' => array(self::$js_path."speciesFilterPopup.js")),
        'indiciaMapPanel' => array('deps' =>array('jquery', 'openlayers', 'jquery_ui', 'jquery_cookie','hoverControl'), 'javascript' => array(self::$js_path."jquery.indiciaMapPanel.js")),
        'indiciaMapEdit' => array('deps' =>array('indiciaMap'), 'javascript' => array(self::$js_path."jquery.indiciaMap.edit.js")),
        'postcode_search' => array('javascript' => array(self::$js_path."postcode_search.js")),
        'locationFinder' => array('deps' =>array('indiciaMapEdit'), 'javascript' => array(self::$js_path."jquery.indiciaMap.edit.locationFinder.js")),
        'createPersonalSites' => array('deps' => array('jquery'), 'javascript' => array(self::$js_path."createPersonalSites.js")),
        'autocomplete' => array(
          'deps' => array('jquery', 'jquery_ui'),
          'javascript' => array(self::$js_path . "indicia.widgets.js")
        ),
        'indicia_locks' => array('deps' => array('jquery_cookie', 'json'), 'javascript' => array(self::$js_path."indicia.locks.js")),
        'jquery_cookie' => array('deps' => array('jquery'), 'javascript' => array(self::$js_path . "jquery.cookie.js")),
        'jquery_ui' => array(
          'deps' => array('jquery'),
          'stylesheets' => array(
            "$indicia_theme_path$indicia_theme/jquery-ui.theme.min.css"
          ),
          'javascript' => array(self::$js_path . "jquery-ui.min.js")
        ),
        'jquery_ui_fr' => array('deps' => array('jquery_ui'), 'javascript' => array(self::$js_path."jquery.ui.datepicker-fr.js")),
        'jquery_form' => array('deps' => array('jquery'), 'javascript' => array(self::$js_path."jquery.form.js")),
        'json' => array('javascript' => array(self::$js_path."json2.js")),
        'reportPicker' => array('deps' => array('treeview'), 'javascript' => array(self::$js_path."reportPicker.js")),
        'treeview' => array('deps' => array('jquery'), 'stylesheets' => array(self::$css_path."jquery.treeview.css"), 'javascript' => array(self::$js_path."jquery.treeview.js")),
        'treeview_async' => array('deps' => array('treeview'), 'javascript' => array(self::$js_path."jquery.treeview.async.js", self::$js_path."jquery.treeview.edit.js")),
        'googlemaps' => array('javascript' => array("$protocol://maps.google.com/maps/api/js?v=3" .
            (empty(self::$google_maps_api_key) ? '' : '&key=' . self::$google_maps_api_key))),
        'virtualearth' => array('javascript' => array("$protocol://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1")),
        'fancybox' => array('deps' => array('jquery'), 'stylesheets' => array(self::$js_path.'fancybox/source/jquery.fancybox.css'), 'javascript' => array(self::$js_path.'fancybox/source/jquery.fancybox.pack.js')),
        'treeBrowser' => array('deps' => array('jquery','jquery_ui'), 'javascript' => array(self::$js_path."jquery.treebrowser.js")),
        'defaultStylesheet' => array(
          'stylesheets' => array(
            self::$css_path . "default_site.css",
            self::$css_path . "theme-generic.css"
          )
        ),
        'validation' => array(
          'deps' => array('jquery'),
          'javascript' => array(
            self::$js_path.'jquery.validate.min.js',
            self::$js_path.'additional-methods.min.js',
            self::$js_path.'indicia.additional-methods.js'
          )
        ),
        'plupload' => array('deps' => array('jquery_ui','fancybox'), 'javascript' => array(
            self::$js_path.'jquery.uploader.js', self::$js_path.'plupload/js/plupload.full.min.js')),
        'jqplot' => array('stylesheets' => array(self::$js_path.'jqplot/jquery.jqplot.min.css'), 'javascript' => array(
                self::$js_path.'jqplot/jquery.jqplot.min.js',
                '[IE]'.self::$js_path.'jqplot/excanvas.js')),
        'jqplot_bar' => array('javascript' => array(self::$js_path.'jqplot/plugins/jqplot.barRenderer.js')),
        'jqplot_pie' => array('javascript' => array(self::$js_path.'jqplot/plugins/jqplot.pieRenderer.js')),
        'jqplot_category_axis_renderer' => array('javascript' => array(self::$js_path.'jqplot/plugins/jqplot.categoryAxisRenderer.js')),
        'jqplot_canvas_axis_label_renderer' => array('javascript' => array(self::$js_path.'jqplot/plugins/jqplot.canvasTextRenderer.js', self::$js_path.'jqplot/plugins/jqplot.canvasAxisLabelRenderer.js')),
        'jqplot_trendline' => array('javascript'=>array(self::$js_path.'jqplot/plugins/jqplot.trendline.js')),
        'reportgrid' => array('deps' => array('jquery_ui', 'jquery_cookie'),
            'javascript' => array(self::$js_path.'jquery.reportgrid.js', self::$js_path.'json2.js')),
        'reportfilters' => array('deps' => array('reportgrid'), 'stylesheets' => array(self::$css_path."report-filters.css"), 'javascript' => array(self::$js_path.'reportFilters.js')),
        'tabs' => array('deps' => array('jquery_ui'), 'javascript' => array(self::$js_path.'tabs.js')),
        'wizardprogress' => array('deps' => array('tabs'), 'stylesheets' => array(self::$css_path."wizard_progress.css")),
        'spatialReports' => array('javascript'=>array(self::$js_path.'spatialReports.js')),
        'jsonwidget' => array('deps' => array('jquery'), 'javascript'=>array(self::$js_path."jsonwidget/json.js", self::$js_path."jsonwidget/jsonedit.js",
            self::$js_path."jquery.jsonwidget.js"), 'stylesheets'=>array(self::$css_path."jsonwidget.css")),
        'timeentry' => array('javascript'=>array(self::$js_path."jquery.timeentry.min.js")),
        'verification' => array('javascript'=>array(self::$js_path."verification.js")),
        'control_speciesmap_controls' => array('deps' =>array('jquery', 'openlayers', 'addrowtogrid', 'validation'), 'javascript' => array(self::$js_path."controls/speciesmap_controls.js")),
        'complexAttrGrid' => array('javascript'=>array(self::$js_path."complexAttrGrid.js")),
        'footable' => array(
            'stylesheets' => array(self::$js_path . 'footable/css/footable.core.min.css'),
//            'javascript' => array( self::$js_path.'footable/dist/footable.min.js',), /*** does not contain bugfixes ***/
            'javascript' => array( self::$js_path . 'footable/js/footable.js',),
            'deps' => array('jquery')),
        'indiciaFootableReport' => array(
            'javascript' => array(self::$js_path . 'jquery.indiciaFootableReport.js'),
            'deps' => array('footable')),
        'indiciaFootableChecklist' => array(
            'stylesheets' => array(self::$css_path . 'jquery.indiciaFootableChecklist.css'),
            'javascript' => array(self::$js_path . 'jquery.indiciaFootableChecklist.js'),
            'deps' => array('footable')),
        'html2pdf' => array(
          'javascript' => array(
            self::$js_path . 'html2pdf/vendor/jspdf.min.js',
            self::$js_path . 'html2pdf/vendor/html2canvas.min.js',
            self::$js_path . 'html2pdf/src/html2pdf.js',
          )
        ),
        'review_input' => array('javascript' => array(self::$js_path . 'jquery.reviewInput.js')),
        'sub_list' => array('javascript' => array(self::$js_path . 'sub_list.js')),
        'georeference_default_geoportal_lu' => array(
            'javascript' => array(self::$js_path.'drivers/georeference/geoportal_lu.js')),
        'georeference_default_google_places' => array(
            'javascript' => array(self::$js_path.'drivers/georeference/google_places.js')),
        'georeference_default_indicia_locations' => array(
            'javascript' => array(self::$js_path.'drivers/georeference/indicia_locations.js')),
        'sref_handlers_4326' => array(
            'javascript' => array(self::$js_path.'drivers/sref/4326.js')),
        'sref_handlers_osgb' => array(
            'javascript' => array(self::$js_path.'drivers/sref/osgb.js')),
        'sref_handlers_osie' => array(
            'javascript' => array(self::$js_path.'drivers/sref/osie.js')),
      );
    }
    return self::$resource_list;
  }

    /**
   * Causes the default_site.css stylesheet to be included in the list of resources on the
   * page. This gives a basic form layout.
   * This also adds default JavaScript to the page to cause buttons to highlight when you
   * hover the mouse over them.
   */
  public static function link_default_stylesheet() {
    // make buttons highlight when hovering over them
    self::$javascript .=  "indiciaFns.enableHoverEffect();\n";
    self::$default_styles = true;
  }

  /**
   * Returns a span containing any validation errors active on the form for the
   * control with the supplied ID.
   *
   * @param string $fieldname
   *   Fieldname of the control to retrieve errors for.
   * @param boolean $plaintext
   *   Set to true to return just the error text, otherwise it is wrapped in a span.
   *
   * @return string HTML for the validation error output.
   */
  public static function check_errors($fieldname, $plaintext=false) {
    $error = '';
    if (self::$validation_errors !== NULL) {
       if (array_key_exists($fieldname, self::$validation_errors)) {
         $errorKey = $fieldname;
       }
       elseif ($fieldname === 'sample:location_id' && array_key_exists('sample:location_name', self::$validation_errors)) {
         // Location autocompletes can have a linked location ID or a freetext
         // location name, so outptu both errors against the control.
         $errorKey = 'sample:location_name';
       }
       elseif (substr($fieldname, -4) === 'date') {
          // For date fields, we also include the type, start and end validation problems
          if (array_key_exists($fieldname.'_start', self::$validation_errors)) {
            $errorKey = $fieldname.'_start';
          }
          if (array_key_exists($fieldname.'_end', self::$validation_errors)) {
            $errorKey = $fieldname.'_end';
          }
          if (array_key_exists($fieldname.'_type', self::$validation_errors)) {
            $errorKey = $fieldname.'_type';
          }
       }
       if (isset($errorKey)) {
         $error = self::$validation_errors[$errorKey];
         // Track errors that were displayed, so we can tell the user about any others.
         self::$displayed_errors[] = $error;
       }
    }
    if (!empty($error)) {
      return $plaintext ? $error : self::apply_error_template($error, $fieldname);
    }
    else {
      return '';
    }
  }

  /**
   * Sends a POST using the cUrl library.
   * @param string $url The URL the POST request is sent to.
   * @param string Arguments to include in the POST data.
   * @param boolean $output_errors Set to false to prevent echoing of errors. Defaults to true.
   * @return array An array with a result element set to true or false for successful or failed posts respectively.
   * The output is returned in an output element in the array. If there is an error, then an errorno element gives the
   * cUrl error number (as generated by the cUrl library used for the post).
   */
  public static function http_post($url, $postargs=null, $output_errors=true) {
    $session = curl_init();
    // Set the POST options.
    curl_setopt ($session, CURLOPT_URL, $url);
    if ($postargs!==null) {
      curl_setopt ($session, CURLOPT_POST, true);
      if (is_array($postargs) && version_compare(phpversion(), '5.5.0') >= 0) {
        // posting a file using @ prefix is deprecated as of version 5.5.0
        foreach ($postargs as $key => $value) {
          // loop through postargs to find files where the value is prefixed @
          if (strpos($value, '@') === 0) {
            // found a file - could be in form @path/to/file;type=mimetype
            $fileparts = explode(';', substr($value, 1));
            $filename = $fileparts[0];
            if (count($fileparts) == 1) {
              // only filename specified
              $postargs[$key] = new CurlFile($filename);
            } else {
              //mimetype may be specified too
              $fileparam = explode('=', $fileparts[1]);
              if ($fileparam[0] == 'type' && isset($fileparam[1])) {
                // found a mimetype
                $mimetype = $fileparam[1];
                $postargs[$key] = new CurlFile($filename, $mimetype);
              } else {
                // the fileparam didn't seem to be a mimetype
                $postargs[$key] = new CurlFile($filename);
              }
            }
          }
        }
      }
      curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
    }
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    // Do the POST and then close the session
    $response = curl_exec($session);
    $httpCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
    $curlErrno = curl_errno($session);
    // Check for an error, or check if the http response was not OK.
    if ($curlErrno || $httpCode != 200) {
      if ($output_errors) {
        echo '<div class="error">cUrl POST request failed. Please check cUrl is installed on the server and the $base_url setting is correct.<br/>URL:'.$url.'<br/>';
        if ($curlErrno) {
          echo 'Error number: '.$curlErrno.'<br/>';
          echo 'Error message: '.curl_error($session).'<br/>';
        }
        echo "Server response<br/>";
        echo $response.'</div>';
      }
      $return = array(
          'result'=>false,
          'output' => $curlErrno ? curl_error($session) : $response,
          'errno' => $curlErrno,
          'status' => $httpCode
      );
    } else {
      $arr_response = explode("\r\n\r\n",$response);
      // last part of response is the actual data
      $return = array('result' => true,'output' => array_pop($arr_response));
    }
    curl_close($session);
    return $return;
  }

  /**
   * Calculates the folder that submitted images end up in according to the helper_config.
   */
  public static function get_uploaded_image_folder() {
    if (!isset(self::$final_image_folder) || self::$final_image_folder=='warehouse') {
      return self::getProxiedBaseUrl() . (isset(self::$indicia_upload_path) ? self::$indicia_upload_path : 'upload/');
    } else {
      return self::getRootFolder() . self::client_helper_path() . self::$final_image_folder;
    }
  }

  /**
   * Returns the client helper folder path, relative to the root folder.
   */
  public static function client_helper_path() {
    // allow integration modules to control path handling, e.g. Drupal).
    if (function_exists('iform_client_helpers_path'))
      return iform_client_helpers_path();
    else {
      $fullpath = str_replace('\\', '/', realpath(__FILE__));
      $root = $_SERVER['DOCUMENT_ROOT'] . self::getRootFolder();
      $root = str_replace('\\', '/', $root);
      $client_helper_path = dirname(str_replace($root, '', $fullpath)) . '/';
      return $client_helper_path;
    }
  }

  /**
   * Calculates the relative path to the client_helpers folder from wherever the current PHP script is.
   */
  public static function relative_client_helper_path() {
    // get the paths to the client helper folder and php file folder as an array of tokens
    $clientHelperFolder = explode(DIRECTORY_SEPARATOR, dirname(realpath(__FILE__)));
    $currentPhpFileFolder = explode(DIRECTORY_SEPARATOR, dirname(realpath($_SERVER['SCRIPT_FILENAME'])));
    // Find the first part of the paths that is not the same
    for($i = 0; $i<min(count($currentPhpFileFolder), count($clientHelperFolder)); $i++) {
      if ($clientHelperFolder[$i] != $currentPhpFileFolder[$i]) {
        break;
      }
    }
    // step back up the path to the point where the 2 paths differ
    $path = str_repeat('../', count($currentPhpFileFolder)-$i);
    // add back in the different part of the path to the client helper folder
    for ($j = $i; $j < count($clientHelperFolder); $j++) {
      $path .= $clientHelperFolder[$j] . '/';
    }
    return $path;
  }

  /**
   * Parameters forms are a quick way of specifying a simple form used to specify the input
   * parameters for a process. Returns the HTML required for a parameters form, e.g. the form
   * defined for input of report parameters or the default values for a csv import.
   * @param array $options Options array with the following possibilities:<ul>
   * <li><b>form</b><br/>
   * Associative array defining the form structure. The structure is the same as described for <em>fixed_values_form</em> in a Warehouse model.
   * @link http://code.google.com/p/indicia/wiki/SampleModelPage.
   * </li>
   * <li><b>id</b><br/>
   * When used for report output, id of the report instance on the page if relevant, so that controls can be given unique ids.
   * </li>
   * <li><b>form</b><br/>
   * Associative array defining the form content.
   * </li>
   * <li><b>readAuth</b><br/>
   * Read authorisation array.
   * </li>
   * <li><b>fieldNamePrefix</b><br/>
   * Optional prefix for form field names.
   * </li>
   * <li><b>defaults</b><br/>
   * Associative array of default values for each form element.
   * </li>
   * <li><b>paramsToHide</b><br/>
   * An optional array of parameter names for parameters that should be added to the form output as hidden inputs rather than visible controls.
   * <li><b>paramsToExclude</b><br/>
   * An optional array of parameter names for parameters that should be skipped in the form output despite being in the form definition.
   * <li><b>forceLookupParamAutocomplete</b><br/>
   * If true, forces lookup parameters to be an autocomplete instead of drop-down.
   * <li><b>forceLookupParamAutocompleteSelectMode</b><br/>
   * Used in conjunction with forceLookupParamAutocomplete, if true then autocomplete parameter control is put into selectMode.
   * </li>
   * <li><b>extraParams</b><br/>
   * Optional array of param names and values that have a fixed value and are therefore output only as a hidden control.
   * </li>
   * <li><b>inlineMapTools</b><br/>
   * Defaults to false. If true, then map drawing parameter tools are embedded into the report parameters form. If false, then the map
   * drawing tools are added to a toolbar at the top of the map.
   * </li>
   * <li><b>helpText</b><br/>
   * Defaults to true. Set to false to disable helpText being displayed alongside controls, useful for building compact versions of
   * simple parameter forms.
   * </li>
   * <li><b>nocache</b><br/>
   * Set to true to disable caching of lookups.
   * </li>
   * </ul>
   * @param boolean $hasVisibleContent On completion, this is set to true if there are visible
   * controls in the params form. If not, then it may be appropriate to skip the displaying of this
   * params form since it is not necessary.
   */
  public static function build_params_form($options, &$hasVisibleContent) {
    require_once('data_entry_helper.php');
    $javascript = '';
    // track if there is anything other than hiddens on the form
    $hasVisibleContent=false;
    // apply defaults
    $options = array_merge(array(
      'inlineMapTools' => false,
      'helpText' => true
    ), $options);
    $r = '';
    // Any ignored parameters will not be in the requested parameter form definition, but we do need hiddens
    if(isset($options['paramsToHide'])){
      foreach($options['paramsToHide'] as $key) {
        $default = isset($options['defaults'][$key]) ? $options['defaults'][$key] : '';
        $fieldPrefix=(isset($options['fieldNamePrefix']) ? $options['fieldNamePrefix'].'-' : '');
        $r .= "<input type=\"hidden\" name=\"$fieldPrefix$key\" value=\"$default\" class=\"test\"/>\n";
      }
    }
    // if doing map tools inline, they don't get added to the page until the map initialises. So capture the JavaScript
    // into a map initialisation hook.
    if (isset($options['paramsInMapToolbar']) && $options['paramsInMapToolbar'])
      self::$javascript .= "mapInitialisationHooks.push(function(div) {\n";
    foreach($options['form'] as $key=>$info) {
      $tools = array();
      // Skip parameters if we have been asked to ignore them
      if (!isset($options['paramsToExclude']) || !in_array($key, $options['paramsToExclude'])) {
        $r .= self::get_params_form_control($key, $info, $options, $tools);
        // If that was a visible setting, then we have to tell the caller that there is something to show.
        if (!isset($options['extraParams']) || !array_key_exists($key, $options['extraParams']))
          $hasVisibleContent=true;
      }
      // If the form has defined any tools to add to the map, we need to create JavaScript to add them to the map.
      if (count($tools)) {
        // wrap JavaScript in a test that the map is on the page
        if (isset($info['allow_buffer']) && $info['allow_buffer']=='true')
          $javascript .= "if (typeof $.fn.indiciaMapPanel!=='undefined') {\n";
        $fieldname=(isset($options['fieldNamePrefix']) ? $options['fieldNamePrefix'].'-' : '') .$key;
        self::add_resource('spatialReports');
        self::add_resource('clearLayer');
        $javascript .= "  enableBuffering();\n";
        if ($options['inlineMapTools']) {
          $r .= '<label>'.$info['display'].':</label>';
          $r .= '<div class="control-box">Use the following tools to define the query area.<br/>'.
          '<div id="map-toolbar" class="olControlEditingToolbar left"></div></div><br/>';
        }
        $r .= '<input type="hidden" name="'.$fieldname.'" id="hidden-wkt" value="'.
            (isset($_POST[$fieldname]) ? $_POST[$fieldname] : '').'"/>';
        if (isset($info['allow_buffer']) && $info['allow_buffer']=='true') {
          $bufferInput = data_entry_helper::text_input(array(
            'label'=>'Buffer (m)',
            'fieldname'=>'geom_buffer',
            'prefixTemplate'=>'blank', // revert to default
            'suffixTemplate'=>'blank', // revert to default
            'class'=>'control-width-1',
            'default'=>isset($_POST['geom_buffer']) ? $_POST['geom_buffer'] : 0
          ));
          if ($options['inlineMapTools'])
            $r .= $bufferInput;
          else {
            $bufferInput = str_replace(array('<br/>',"\n"), '', $bufferInput);
            $javascript .= "$.fn.indiciaMapPanel.defaults.toolbarSuffix+='$bufferInput';\n";
          }
          // keep a copy of the unbuffered polygons in this input, so that when the page reloads both versions
          // are available
          $r .= '<input type="hidden" name="orig-wkt" id="orig-wkt" '.
              'value="'.(isset($_POST['orig-wkt']) ? $_POST['orig-wkt'] : '')."\" />\n";
        }
        // Output some JavaScript to setup a toolbar for the map drawing tools. Also JS
        // to handle getting the polygons from the edit layer into the report parameter
        // when run report is clicked.
        $toolbarDiv = $options['inlineMapTools'] ? 'map-toolbar' : 'top';
        $javascript .= "
  $.fn.indiciaMapPanel.defaults.toolbarDiv='$toolbarDiv';
  mapInitialisationHooks.push(function(div) {
    var styleMap = new OpenLayers.StyleMap(OpenLayers.Util.applyDefaults(
          {fillOpacity: 0.05},
          OpenLayers.Feature.Vector.style['default']));
    div.map.editLayer.styleMap = styleMap;\n";

        if (isset($info['allow_buffer']) && $info['allow_buffer']=='true')
          $origWkt = empty($_POST['orig-wkt']) ? '' : $_POST['orig-wkt'];
        else
          $origWkt = empty($_POST[$fieldname]) ? '' : $_POST[$fieldname];

        if (!empty($origWkt)) {
          $javascript .= "  var geom=OpenLayers.Geometry.fromWKT('$origWkt');\n";
          $javascript .= "  if (div.map.projection.getCode() !== div.indiciaProjection.getCode()) {\n";
          $javascript .= "    geom.transform(div.indiciaProjection, div.map.projection);\n";
          $javascript .= "  }\n";
          $javascript .= "  div.map.editLayer.addFeatures([new OpenLayers.Feature.Vector(geom)]);\n";
        }
        $javascript .= "
  });
  var add_map_tools = function(opts) {\n";
        foreach ($tools as $tool) {
          $javascript .= "  opts.standardControls.push('draw$tool');\n";
        }
        $javascript .= "  opts.standardControls.push('clearEditLayer');
  };
  mapSettingsHooks.push(add_map_tools);\n";
        if (isset($info['allow_buffer']) && $info['allow_buffer']=='true')
          $javascript .= "}\n";
      }
    }
    // closure for the map initialisation hooks.
    if (isset($options['paramsInMapToolbar']) && $options['paramsInMapToolbar'])
      self::$javascript .= "});";
    self::$javascript .= $javascript;
    return $r;
  }

  /**
   * Internal method to safely find the value of a preset parameter. Returns empty string if not defined.
   * @param array $options The options array, containing a extraParams entry that the parameter should be
   * found in.
   * @param string $name The key identifying the preset parameter to look for.
   * @return string Value of preset parameter or empty string.
   */
  private static function get_preset_param($options, $name) {
    if (!isset($options['extraParams']))
      return '';
    else if (!isset($options['extraParams'][$name]))
      return '';
    else
      return $options['extraParams'][$name];
  }

  /**
   * Returns a control to insert onto a parameters form.
   * @param string $key The unique identifier of this control.
   * @param array $info Configuration options for the parameter as defined in the report, including the
   * description, display (label), default and datatype.
   * @param array $options Control options array
   * @param array $tools Any tools to be embedded in the map toolbar are returned in this
   * parameter rather than as the return result of the function.
   * @return string The HTML for the form parameter.
   */
  private static function get_params_form_control($key, $info, $options, &$tools) {
    $r = '';

    $fieldPrefix=(isset($options['fieldNamePrefix']) ? $options['fieldNamePrefix'].'-' : '');
    $ctrlOptions = array(
      'label' => lang::get($info['display']),
      'helpText' => $options['helpText'] ? $info['description'] : '', // note we can't fit help text in the toolbar versions of a params form
      'fieldname' => $fieldPrefix.$key,
      'nocache' => isset($options['nocache']) && $options['nocache']
    );
    // If this parameter is in the URL or post data, put it in the control instead of the original default
    if (isset($options['defaults'][$key]))
      $ctrlOptions['default'] = $options['defaults'][$key];
    elseif (isset($info['default']))
      $ctrlOptions['default'] = $info['default'];
    if ($info['datatype']=='idlist') {
      // idlists are not for human input so use a hidden.
      $r .= "<input type=\"hidden\" name=\"$fieldPrefix$key\" value=\"".self::get_preset_param($options, $key)."\" class=\"".$fieldPrefix."idlist-param\" />\n";
    } elseif (isset($options['extraParams']) && array_key_exists($key, $options['extraParams'])) {
      $r .= "<input type=\"hidden\" name=\"$fieldPrefix$key\" value=\"".self::get_preset_param($options, $key)."\" />\n";
      //if the report parameter is a lookup and its population_call is set to species_autocomplete
      //Options such as @speciesIncludeBothNames can be included as a [params] control form structure
      //option
    } elseif ($info['datatype']=='lookup' && (isset($info['population_call']) && $info['population_call']=='autocomplete:species')) {
      $ctrlOptions['extraParams']=$options['readAuth'];
      if (!empty($options['speciesTaxonListId']))
        $ctrlOptions['extraParams']['taxon_list_id']=$options['speciesTaxonListId'];
      if (!empty($options['speciesIncludeBothNames'])&&$options['speciesIncludeBothNames']==true)
        $ctrlOptions['speciesIncludeBothNames']=true;
      if (!empty($options['speciesIncludeTaxonGroup'])&&$options['speciesIncludeTaxonGroup']==true)
        $ctrlOptions['speciesIncludeTaxonGroup']=true;
      $r .= data_entry_helper::species_autocomplete($ctrlOptions);
    } elseif ($info['datatype']=='lookup' && isset($info['population_call'])) {
      // population call is colon separated, of the form direct|report:table|view|report:idField:captionField:params(key=value,key=value,...)
      $popOpts = explode(':', $info['population_call']);
      $extras = array();
      // if there are any extra parameters on the report lookup call, apply them
      if (count($popOpts) >= 5) {
        // because any extra params might contain colons, any colons from item 5 onwards are considered part of the extra params. So we
        // have to take the remaining items and re-implode them, then split them by commas instead. E.g. population call could be set to
        // direct:term:id:term:term=a:b - in this case option 5 (term=a:b) is not to be split by colons.
        $extraItems = explode(',', implode(':', array_slice($popOpts, 4)));
        foreach ($extraItems as $extraItem) {
          $extraItem = explode('=', $extraItem);
          $extras[$extraItem[0]] = $extraItem[1];
        }
      }
      // allow local page configuration to apply extra restrictions on the return values: e.g. only return some location_types from the termlist
      if(isset($options['param_lookup_extras']) && isset($options['param_lookup_extras'][$key])){
        foreach($options['param_lookup_extras'][$key] as $param => $value)
          // direct table access can handle 'in' statements, reports can't.
          $extras[$param] = ($popOpts[0]=='direct' ? $value : (is_array($value) ? implode(',',$value) : $value));
          // $extras[$param] = $value;
      }
      if (!isset($extras['orderby']))
        $extras['orderby'] = $popOpts[3];
      $ctrlOptions = array_merge($ctrlOptions, array(
        'valueField'=>$popOpts[2],
        'captionField'=>$popOpts[3],
        'blankText'=>'<please select>',
        'extraParams'=>$options['readAuth'] + $extras
      ));
      if ($popOpts[0]=='direct')
        $ctrlOptions['table']=$popOpts[1];
      else
        $ctrlOptions['report']=$popOpts[1];
      if (isset($info['linked_to']) && isset($info['linked_filter_field'])) {
        $ctrlOptions['filterIncludesNulls'] = (isset($info['filterIncludesNulls']) ? $info['filterIncludesNulls'] : false); //exclude null entries from filter field by default

        if (isset($options['extraParams']) && array_key_exists($info['linked_to'], $options['extraParams'])) {
          // if the control this is linked to is hidden because it has a preset value, just use that value as a filter on the
          // population call for this control
          $ctrlOptions = array_merge($ctrlOptions, array(
            'extraParams' => array_merge($ctrlOptions['extraParams'], array('query'=>json_encode(
                array('in'=>array($info['linked_filter_field']=>array($options['extraParams'][$info['linked_to']], null)))
            )))
          ));
        } else {
          // otherwise link the 2 controls
          $ctrlOptions = array_merge($ctrlOptions, array(
            'parentControlId' => $fieldPrefix.$info['linked_to'],
            'filterField' => $info['linked_filter_field'],
            'parentControlLabel' => $options['form'][$info['linked_to']]['display']
          ));
        }
      }
      $r .= data_entry_helper::select($ctrlOptions);
    } elseif ($info['datatype']=='lookup' && isset($info['lookup_values'])) {
      // Convert the lookup values into an associative array
      $lookups = explode(',', $info['lookup_values']);
      $lookupsAssoc = array();
      foreach($lookups as $lookup) {
        $lookup = explode(':', $lookup);
        $lookupsAssoc[$lookup[0]] = $lookup[1];
      }
      $ctrlOptions = array_merge($ctrlOptions, array(
        'blankText'=>'<'.lang::get('please select').'>',
        'lookupValues' => $lookupsAssoc
      ));
      $r .= data_entry_helper::select($ctrlOptions);
    } elseif ($info['datatype']=='date') {
      $r .= data_entry_helper::date_picker($ctrlOptions);
    } elseif ($info['datatype']=='geometry') {
      $tools = array('Polygon','Line','Point');
    } elseif ($info['datatype']=='polygon') {
      $tools = array('Polygon');
    } elseif ($info['datatype']=='line') {
      $tools = array('Line');
    } elseif ($info['datatype']=='point') {
      $tools = array('Point');
    } else {
      if (method_exists('data_entry_helper', $info['datatype'])) {
        $ctrl = $info['datatype'];
        $r .= data_entry_helper::$ctrl($ctrlOptions);
      } else {
        $r .= data_entry_helper::text_input($ctrlOptions);
      }
    }
    return $r;
  }

  /**
   * Utility method that returns the parts required to build a link back to the current page.
   * @return array Associative array containing path and params (itself a key/value paired associative array).
   */
  public static function get_reload_link_parts() {
    $split = strpos($_SERVER['REQUEST_URI'], '?');
    // convert the query parameters into an array
    $gets = ($split!==false && strlen($_SERVER['REQUEST_URI']) > $split+1) ?
        explode('&', substr($_SERVER['REQUEST_URI'], $split+1)) :
        array();
    $getsAssoc = array();
    foreach ($gets as $get) {
      $tokens = explode('=', $get);
      // ensure a key without value in the URL gets an empty value
      if (count($tokens)===1) $tokens[] = '';
      $getsAssoc[$tokens[0]] = $tokens[1];
    }
    $path = $split!==false ? substr($_SERVER['REQUEST_URI'], 0, $split) : $_SERVER['REQUEST_URI'];
    return array(
      'path'=>$path,
      'params' => $getsAssoc
    );
  }

  /**
   * Takes an associative array and converts it to a list of params for a query string. This is like
   * http_build_query but it does not url encode the & separator, and gives control over urlencoding the array values.
   * @param array $array Associative array to convert.
   * @param boolean $encodeValues Default false. Set to true to URL encode the values being added to the string.
   * @return string The query string.
   */
  public static function array_to_query_string($array, $encodeValues=false) {
    $params = array();
    if(is_array($array)) {
      arsort($array);
      foreach ($array as $a => $b)
      {
        if ($encodeValues) $b=urlencode($b);
        $params[] = "$a=$b";
      }
    }
    return implode('&', $params);
  }

    /**
   * Applies a output template to an array. This is used to build the output for each item in a list,
   * such as a species checklist grid or a radio group.
   *
   * @param array $params Array holding the parameters to merge into the template.
   * @param string $template Name of the template to use, or actual template text if
   * $useTemplateAsIs is set to true.
   * @param boolean $useTemplateAsIs If true then the template parameter contains the actual
   * template text, otherwise it is the name of a template in the $indicia_templates array. Default false.
   * @param boolean $allowHtml If true then HTML is emitted as is from the parameter values inserted into the template,
   * otherwise they are escaped.
   * @param boolean $allowEscapeQuotes If true then parameter names can be suffixes -esape-quote, -escape-dblquote,
   * -escape-htmlquote or -escape-htmldblquote to insert backslashes or html entities into the replacements for string escaping.
   * @return string HTML for the item label
   */
  public static function mergeParamsIntoTemplate($params, $template, $useTemplateAsIs=false, $allowHtml=false, $allowEscapeQuotes=false) {
    global $indicia_templates;
    // Build an array of all the possible tags we could replace in the template.
    $replaceTags=array();
    $replaceValues=array();
    foreach ($params as $param=>$value) {
      if (!is_array($value) && !is_object($value)) {
        array_push($replaceTags, '{'.$param.'}');
        if ($allowEscapeQuotes) {
          array_push($replaceTags, '{'.$param.'-escape-quote}');
          array_push($replaceTags, '{'.$param.'-escape-dblquote}');
          array_push($replaceTags, '{'.$param.'-escape-htmlquote}');
          array_push($replaceTags, '{'.$param.'-escape-htmldblquote}');
        }
        // allow sep to have <br/>
        $value = ($param == 'sep' || $allowHtml) ? $value : htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        // HTML attributes get automatically wrapped
        if (in_array($param, self::$html_attributes) && !empty($value))
          $value = " $param=\"$value\"";
        array_push($replaceValues, $value);
        if ($allowEscapeQuotes) {
          array_push($replaceValues, str_replace("'","\'",$value));
          array_push($replaceValues, str_replace('"','\"',$value));
          array_push($replaceValues, str_replace("'","&#39;",$value));
          array_push($replaceValues, str_replace('"','&quot;',$value));
        }
      }
    }
    if (!$useTemplateAsIs) $template = $indicia_templates[$template];
    return str_replace($replaceTags, $replaceValues, $template);
  }

  /**
   * Takes a file that has been uploaded to the client website upload folder, and moves it to the warehouse upload folder using the
   * data services.
   *
   * @param string $path Path to the file to upload, relative to the interim image path folder (normally the
   * client_helpers/upload folder.
   * @param boolean $persist_auth Allows the write nonce to be preserved after sending the file, useful when several files
   * are being uploaded.
   * @param array $readAuth Read authorisation tokens, if not supplied then the $_POST array should contain them.
   * @param string $service Path to the service URL used. Default is data/handle_media, but could be import/upload_csv.
   * @return string Error message, or true if successful.
   */
  public static function send_file_to_warehouse($path, $persist_auth=false, $readAuth = null, $service='data/handle_media') {
    if ($readAuth == NULL) {
      $readAuth = $_POST;
    }
    $interimPath = self::getInterimImageFolder('fullpath');
    if (!file_exists($interimPath.$path))
      return "The file $interimPath$path does not exist and cannot be uploaded to the Warehouse.";
    $serviceUrl = self ::$base_url . "index.php/services/$service";
    // This is used by the file box control which renames uploaded files using a guid system, so disable renaming on the server.
    $postargs = array('name_is_guid' => 'true');
    // attach authentication details
    if (array_key_exists('auth_token', $readAuth))
      $postargs['auth_token'] = $readAuth['auth_token'];
    if (array_key_exists('nonce', $readAuth))
      $postargs['nonce'] = $readAuth['nonce'];
    if ($persist_auth)
      $postargs['persist_auth'] = 'true';
    $file_to_upload = array('media_upload'=>'@'.realpath($interimPath.$path));
    $response = self::http_post($serviceUrl, $file_to_upload + $postargs);
    $output = json_decode($response['output'], true);
    $r = true; // default is success
    if (is_array($output)) {
      //an array signals an error
      if (array_key_exists('error', $output)) {
        // return the most detailed bit of error information
        if (isset($output['errors']['media_upload']))
          $r = $output['errors']['media_upload'];
        else
          $r = $output['error'];
      }
    }
    unlink(realpath($interimPath.$path));
    return $r;
  }

 /**
  * Internal function to find the path to the root of the site, including the trailing slash.
  * @param boolean $allowForDirtyUrls Set to true to allow for the content management system's
  * approach to dirty URLs
  *
  */
  public static function getRootFolder($allowForDirtyUrls = false) {
    // $_SERVER['SCRIPT_NAME'] can, in contrast to $_SERVER['PHP_SELF'], not
    // be modified by a visitor.
    if ($dir = trim(dirname($_SERVER['SCRIPT_NAME']), '\,/'))
      $r = "/$dir/";
    else
      $r = '/';
    $pathParam = ($allowForDirtyUrls && function_exists('variable_get') && variable_get('clean_url', 0)=='0') ? 'q' : '';
    $r .= empty($pathParam) ? '' : "?$pathParam=";
    return $r;
  }

  /**
  * Retrieves a token and inserts it into a data entry form which authenticates that the
  * form was submitted by this website.
  *
  * @param string $website_id Indicia ID for the website.
  * @param string $password Indicia password for the website.
  */
  public static function get_auth($website_id, $password) {
    self::$website_id = $website_id;
    $postargs = "website_id=$website_id";
    $response = self::http_post(self::$base_url . 'index.php/services/security/get_nonce', $postargs);
    if (isset($response['status'])) {
      if ($response['status'] === 404) {
        throw new Exception(lang::get('The warehouse URL {1} was not found. Either the warehouse is down or the ' .
          'Indicia configuration is incorrect.', self::$base_url), 404);
      }
      else {
        throw new Exception($response['output'], $response['status']);
      }
    }
    $nonce = $response['output'];
    $result = '<input id="auth_token" name="auth_token" type="hidden" class="hidden" ' .
        'value="'.sha1("$nonce:$password").'" />'."\r\n";
    $result .= '<input id="nonce" name="nonce" type="hidden" class="hidden" ' .
        'value="'.$nonce.'" />'."\r\n";
    return $result;
  }

  /**
   * Retrieves a read token and passes it back as an array suitable to drop into the
   * 'extraParams' options for an Ajax call.
   *
   * @param string $website_id Indicia ID for the website.
   * @param string $password Indicia password for the website.
   * @return array Read authorisation tokens array.
   * @throws Exception
   */
  public static function get_read_auth($website_id, $password) {
    self::$website_id = $website_id; /* Store this for use with data caching */
    // Keep a non-random cache for 10 minutes. It MUST be shorter than the normal cache lifetime so this expires more frequently.
    $r = self::cache_get(array('readauth-wid'=>$website_id), 600, false);
    if ($r===false) {
      $postargs = "website_id=$website_id";
      $response = self::http_post(self::$base_url.'index.php/services/security/get_read_nonce', $postargs, false);
      if (isset($response['status'])) {
        if ($response['status'] === 404) {
          throw new Exception(lang::get('The warehouse URL {1} was not found. Either the warehouse is down or the ' .
            'Indicia configuration is incorrect.', self::$base_url), 404);
        }
        else {
          throw new Exception($response['output'], $response['status']);
        }
      }
      $nonce = $response['output'];
      if (substr($nonce, 0, 9) === '<!DOCTYPE')
        throw new Exception(lang::get('Could not authenticate against the warehouse. Is the server down?'));
      $r = array(
          'auth_token' => sha1("$nonce:$password"),
          'nonce' => $nonce
      );
      self::cache_set(array('readauth-wid'=>$website_id), json_encode($r));
    }
    else
      $r = json_decode($r, TRUE);
    self::$js_read_tokens = $r;
    return $r;
  }

/**
  * Retrieves read and write nonce tokens from the warehouse.
  * @param string $website_id Indicia ID for the website.
  * @param string $password Indicia password for the website.
  * @return array Returns an array containing:
  * 'read' => the read authorisation array,
  * 'write' => the write authorisation input controls to insert into your form.
  * 'write_tokens' => the write authorisation array, if needed as separate tokens rather than just placing in form.
  */
  public static function get_read_write_auth($website_id, $password) {
    self::$website_id = $website_id; /* Store this for use with data caching */
    $postargs = "website_id=$website_id";
    $response = self::http_post(self::$base_url.'index.php/services/security/get_read_write_nonces', $postargs);
    if (array_key_exists('status', $response)) {
      if ($response['status'] === 404) {
        throw new Exception(lang::get('The warehouse URL {1} was not found. Either the warehouse is down or the ' .
          'Indicia configuration is incorrect.', self::$base_url), 404);
      }
      else {
        throw new Exception($response['output'], $response['status']);
      }
    }
    $nonces = json_decode($response['output'], true);
    $write = '<input id="auth_token" name="auth_token" type="hidden" class="hidden" ' .
        'value="'.sha1($nonces['write'].':'.$password).'" />'."\r\n";
    $write .= '<input id="nonce" name="nonce" type="hidden" class="hidden" ' .
        'value="'.$nonces['write'].'" />'."\r\n";
    self::$js_read_tokens = array(
      'auth_token' => sha1($nonces['read'].':'.$password),
      'nonce' => $nonces['read']
    );
    return array(
      'write' => $write,
      'read' => self::$js_read_tokens,
      'write_tokens' => array(
        'auth_token' => sha1($nonces['write'].':'.$password),
        'nonce' => $nonces['write']
      ),
    );
  }

  /**
   * This method allows JavaScript and CSS links to be created and placed in the <head> of the
   * HTML file rather than using dump_javascript which must be called after the form is built.
   * The advantage of dump_javascript is that it intelligently builds the required links
   * depending on what is on your form. dump_header is not intelligent because the form is not
   * built yet, but placing links in the header leads to cleaner code which validates better.
   * @param array $resources List of resources to include in the header. The available options are described
   * in the documentation for the add_resource method. The default for this is jquery_ui and defaultStylesheet.
   *
   * @return string Text to place in the head section of the html file.
   */
  public static function dump_header($resources=null) {
    if (!$resources) {
      $resources = array('jquery_ui',  'defaultStylesheet');
    }
    foreach ($resources as $resource) {
      self::add_resource($resource);
    }
    // place a css class on the body if JavaScript enabled. And output the resources
    return self::internal_dump_resources(self::$required_resources) .
        self::get_scripts('$("body").addClass("js");', '', '', true);
  }

  /**
  * Helper function to collect javascript code in a single location. Should be called at the end of each HTML
  * page which uses the data entry helper so output all JavaScript required by previous calls.
  * @param boolean $closure Set to true to close the JS with a function to ensure $ will refer to jQuery.
  * @return string JavaScript to insert into the page for all the controls added to the page so far.
  *
  * @link http://code.google.com/p/indicia/wiki/TutorialBuildingBasicPage#Build_a_data_entry_page
  */
  public static function dump_javascript($closure=false) {
    // Add the default stylesheet to the end of the list, so it has highest CSS priority
    if (self::$default_styles) {
      self::add_resource('defaultStylesheet');
    }
    // Jquery validation js has to be added at this late stage, because only then do we know all the messages required.
    self::setup_jquery_validation_js();
    $dump = self::internal_dump_resources(self::$required_resources);
    $dump .= self::get_scripts(self::$javascript, self::$late_javascript, self::$onload_javascript, true, $closure);
    // ensure scripted JS does not output again if recalled.
    self::$javascript = "";
    self::$late_javascript = "";
    self::$onload_javascript = "";
    return $dump;
  }

  /**
   * Internal implementation of the dump_javascript method which takes the javascript and resources list
   * as flexible parameters, rather that using the globals.
   * @param array $resources List of resources to include.
   * @access private
   */
  protected static function internal_dump_resources($resources) {
    $libraries = '';
    $stylesheets = '';
    if (isset($resources)) {
      $resourceList = self::get_resources();
      foreach ($resources as $resource) {
        if (!in_array($resource, self::$dumped_resources)) {
          if (isset($resourceList[$resource]['stylesheets'])) {
            foreach ($resourceList[$resource]['stylesheets'] as $s) {
              $stylesheets .= "<link rel='stylesheet' type='text/css' href='$s' />\n";
            }
          }
          if (isset($resourceList[$resource]['javascript'])) {
            foreach ($resourceList[$resource]['javascript'] as $j) {
              // if enabling fancybox, link it up
              if (strpos($j, 'fancybox.') !== FALSE) {
                self::$javascript .= "$('a.fancybox').fancybox({ afterLoad: indiciaFns.afterFancyboxLoad });\n";
              }
              // look out for a condition that this script is IE only.
              if (substr($j, 0, 4)=='[IE]'){
              	$libraries .= "<!--[if IE]><script type=\"text/javascript\" src=\"".substr($j, 4)."\"></script><![endif]-->\n";
              }
              else {
                $libraries .= "<script type=\"text/javascript\" src=\"$j\"></script>\n";
              }
            }
          }
          // Record the resource as being dumped, so we don't do it again.
          array_push(self::$dumped_resources, $resource);
        }
      }
    }
    return $stylesheets.$libraries;
  }

  /**
   * A utility function for building the inline script content which should be inserted into a page from the javaascript,
   * late javascript and onload javascript. Can optionally include the script tags wrapper around the script generated.
   * @param string $javascript JavaScript to run when the page is ready, i.e. in $(document).ready.
   * @param string $late_javascript JavaScript to run at the end of $(document).ready.
   * @param string $onload_javascript JavaScript to run in the window.onLoad handler which comes later in the page load process.
   * @param bool $includeWrapper If true then includes script tags around the script.
   * @param bool $closure Set to true to close the JS with a function to ensure $ will refer to jQuery.
   */
  public static function get_scripts($javascript, $late_javascript, $onload_javascript, $includeWrapper=false, $closure=false) {
    if (!empty($javascript) || !empty($late_javascript) || !empty($onload_javascript)) {
      $proxyUrl = self::relative_client_helper_path() . 'proxy.php';
      $protocol = empty($_SERVER['HTTPS']) || $_SERVER['HTTPS']==='off' ? 'http' : 'https';
      $script = $includeWrapper ? "<script type='text/javascript'>/* <![CDATA[ */\n" : "";
      $script .= $closure ? "(function ($) {\n" : "";
      $script .= "
indiciaData.imagesPath='" . self::$images_path . "';
indiciaData.warehouseUrl='" . self::$base_url . "';
indiciaData.proxyUrl='$proxyUrl';
indiciaData.protocol='$protocol';
indiciaData.jQuery = jQuery; //saving the current version of jQuery
";
      if (!empty(self::$website_id)) {
        // not on warehouse
        $script .= "indiciaData.website_id = " . self::$website_id . ";\n";
        if (function_exists('hostsite_get_user_field')) {
          $userId = hostsite_get_user_field('indicia_user_id');
          if ($userId) {
            $script .= "indiciaData.user_id = $userId;\n";
          }
        }
      }

      if (self::$js_read_tokens) {
        self::$js_read_tokens['url'] = self::getProxiedBaseUrl();
        $script .= "indiciaData.read = ".json_encode(self::$js_read_tokens).";\n";
      }
      if (!empty($javascript) || !empty($late_javascript)) {
        if (!self::$is_ajax) {
          $script .= "$(document).ready(function() {\n";
        }
        $script .= <<<JS
indiciaData.documentReady = 'started';
$javascript
$late_javascript
// if window.onload already happened before document.ready, ensure any hooks are still run.
if (indiciaData.windowLoaded === 'done') {
  $.each(indiciaData.onloadFns, function(idx, fn) {
    fn();
  });
}
indiciaData.documentReady = 'done';

JS;
        if (!self::$is_ajax) {
          $script .= "});\n";
        }
      }
      if (!empty($onload_javascript)) {
        if (self::$is_ajax) // ajax requests are simple - page has already loaded so just return the javascript
          $script .= "$onload_javascript\n";
        else {
          // If no code running on docReady, can proceed with onload without testing.
          $documentReadyDone = empty($javascript) && empty($late_javascript) ? "indiciaData.documentReady = 'done';" : '';
          // create a function that can be called from window.onLoad. Don't put it directly in the onload
          // in case another form is added to the same page which overwrites onload.
          $script .= <<<JS
$documentReadyDone
indiciaData.onloadFns.push(function() {
  $onload_javascript
});
window.onload = function() {
  indiciaData.windowLoad = 'started';
  // ensure this is only run after document.ready
  if (indiciaData.documentReady === 'done') {
    $.each(indiciaData.onloadFns, function(idx, fn) {
      fn();
    });
  }
  indiciaData.windowLoaded = 'done';
}

JS;
        }
      }
      $script .= $closure ? "})(jQuery);\n" : "";
      $script .= $includeWrapper ? "/* ]]> */</script>\n" : "";
    } else {
      $script='';
    }
    return $script;
  }

  /**
   * If required, setup jQuery validation. This JavaScript must be added at the end of form preparation otherwise we would
   * not know all the control messages. It will normally be called by dump_javascript automatically, but is exposed here
   * as a public method since the iform Drupal module does not call dump_javascript, but is responsible for adding JavaScript
   * to the page via drupal_add_js.
   */
  public static function setup_jquery_validation_js() {
    // In the following block, we set the validation plugin's error class to our template.
    // We also define the error label to be wrapped in a <p> if it is on a newline.
    if (self::$validated_form_id) {
      global $indicia_templates;
      self::$javascript .= "
indiciaData.controlWrapErrorClass = '$indicia_templates[controlWrapErrorClass]';
// Trim data before validation.
$('#".self::$validated_form_id."').submit(function() {
  $.each($(this).find('input,textarea'), function() {
    $(this).val($(this).val().trim());
  });
});
var validator = $('#".self::$validated_form_id."').validate({
  ignore: \":hidden,.inactive\",
  errorClass: \"$indicia_templates[error_class]\",
  ". (in_array('inline', self::$validation_mode) ? "" : "errorElement: 'p',") ."
  highlight: function(el, errorClass) {
    var controlWrap = $(el).closest('.ctrl-wrap');
    if (controlWrap.length > 0) {
      $(controlWrap).addClass(indiciaData.controlWrapErrorClass);
    }
    if ($(el).is(':radio') || $(el).is(':checkbox')) {
      //if the element is a radio or checkbox group then highlight the group
      var jqBox = $(el).parents('.control-box');
      if (jqBox.length !== 0) {
        jqBox.eq(0).addClass('ui-state-error');
      } else {
        $(el).addClass('ui-state-error');
      }
    } else {
      $(el).addClass('ui-state-error');
    }
  },
  unhighlight: function(el, errorClass) {
    var controlWrap = $(el).closest('.ctrl-wrap');
    if (controlWrap.length > 0) {
      $(controlWrap).removeClass(indiciaData.controlWrapErrorClass);
    }
    if ($(el).is(':radio') || $(el).is(':checkbox')) {
      //if the element is a radio or checkbox group then highlight the group
      var jqBox = $(el).parents('.control-box');
      if (jqBox.length !== 0) {
        jqBox.eq(0).removeClass('ui-state-error');
      } else {
        $(el).removeClass('ui-state-error');
      }
    } else {
      $(el).removeClass('ui-state-error');
    }
  },
  invalidHandler: $indicia_templates[invalid_handler_javascript],
  messages: ".json_encode(self::$validation_messages).",".
  // Do not place errors if 'message' not in validation_mode
  // if it is present, put radio button messages at start of list:
  // radio and checkbox elements come before their labels, so putting the error after the invalid element
  // places it between the element and its label.
  // most radio button validation will be "required"
  (in_array('message', self::$validation_mode) ? "
  errorPlacement: function(error, element) {
    var jqBox, nexts;
    // If using Bootstrap input-group class, put the message after the group
    var inputGroup = $(element).closest('.input-group');
    if (inputGroup.length) {
      element = inputGroup;
    } else {
      if(element.is(':radio')||element.is(':checkbox')){
        jqBox = element.parents('.control-box');
        element=jqBox.length === 0 ? element : jqBox;
      }
      nexts=element.nextAll(':visible');
      if (nexts) {
        $.each(nexts, function() {
          if ($(this).hasClass('deh-required') || $(this).hasClass('locked-icon') || $(this).hasClass('unlocked-icon')) {
            element = this;
          }
        });
      }
    }
    error.insertAfter(element);
  }" : "
  errorPlacement: function(error, element) {}") ."
});
//Don't validate whilst user is still typing in field
if (typeof validator!=='undefined') {
  validator.settings.onkeyup = false;
}
\n";
    }
  }

  /**
   * Internal method to build a control from its options array and its template. Outputs the
   * prefix template, a label (if in the options), a control, the control's errors and a
   * suffix template.
   *
   * @param string $template Name of the control template, from the global $indicia_templates variable.
   * @param array $options Options array containing the control replacement values for the templates.
   * Options can contain a setting for prefixTemplate or suffixTemplate to override the standard templates.
   */
  public static function apply_template($template, $options) {
    global $indicia_templates;
    // Don't need the extraParams - they are just for service communication.
    $options['extraParams'] = NULL;
    // Set default validation error output mode
    if (!array_key_exists('validation_mode', $options)) {
      $options['validation_mode'] = self::$validation_mode;
    }
    // Decide if the main control has an error. If so, highlight with the error class and set it's title.
    $error="";
    if (self::$validation_errors !== NULL) {
      if (array_key_exists('fieldname', $options)) {
        $error = self::check_errors($options['fieldname'], TRUE);
      }
    }
    // Add a hint to the control if there is an error and this option is set, or a hint option
    if (($error && in_array('hint', $options['validation_mode'])) || isset($options['hint'])) {
      $hint = ($error && in_array('hint', $options['validation_mode'])) ? array($error) : array();
      if(isset($options['hint'])) $hint[] = $options['hint'];
      $options['title'] = 'title="'.implode(' : ',$hint).'"';
    } else {
      $options['title'] = '';
    }
    $options = array_merge(array(
      'class' => '',
      'disabled' => '',
      'readonly' => '',
      'attributes' => '',
    ), $options);
    if (array_key_exists('maxlength', $options)) {
      $options['maxlength']='maxlength="'.$options['maxlength'].'"';
    } else {
      $options['maxlength']='';
    }
    // Add an error class to colour the control if there is an error and this option is set
    if ($error && in_array('colour', $options['validation_mode'])) {
      $options['class'] .= ' ui-state-error';
      if (array_key_exists('outerClass', $options)) {
        $options['outerClass'] .= ' ui-state-error';
      } else {
        $options['outerClass'] = 'ui-state-error';
      }
    }
    // Allows a form control to have a class specific to the base theme.
    if (isset($options['isFormControl']) && isset($indicia_templates['formControlClass'])) {
      $options['class'] .= " $indicia_templates[formControlClass]";
    }
    // Add validation metadata to the control if specified, as long as control has a fieldname.
    $options['attributes'] = self::buildElementAttributes($options);
    // replace html attributes with their wrapped versions, e.g. a class becomes class="..."
    foreach (self::$html_attributes as $name => $attr) {
      if (!empty($options[$name])) {
        $options[$name]=' '.$attr.'="'.$options[$name].'"';
      }
    }
    // If options contain a help text, output it at the end if that is the preferred position
    $r = self::get_help_text($options, 'before');
    // Add prefix.
    $r .= self::apply_static_template('prefix', $options);

    // Add a label only if specified in the options array. Link the label to the inputId if available,
    // otherwise the fieldname (as the fieldname control could be a hidden control).
    if (!empty($options['label'])) {
      $labelTemplate = isset($options['labelTemplate']) ? $indicia_templates[$options['labelTemplate']] :
      	(substr($options['label'], -1) == '?' ? $indicia_templates['labelNoColon'] : $indicia_templates['label']);
      $label = str_replace(
          array('{label}', '{id}', '{labelClass}'),
          array(
              $options['label'],
              array_key_exists('inputId', $options) ? $options['inputId'] : $options['id'],
              array_key_exists('labelClass', $options) ? ' class="'.$options['labelClass'].'"' : '',
          ),
          $labelTemplate
      );
    }
    if (!empty($options['label']) && (!isset($options['labelPosition']) || $options['labelPosition'] != 'after')) {
    	$r .= $label;
    }
    // Output the main control
    $control = self::apply_replacements_to_template($indicia_templates[$template], $options);
    $addons = '';

    if (isset($options['afterControl'])) {
      $addons .= $options['afterControl'];
    }
    // Add a lock icon to the control if the lockable option is set to true
    if (array_key_exists('lockable', $options) && $options['lockable']===true) {
      $addons .= self::apply_replacements_to_template($indicia_templates['lock_icon'], $options);
      if (!self::$using_locking) {
        self::$using_locking = true;
        $options['lock_form_mode'] = self::$form_mode ? self::$form_mode : 'NEW';
        // write lock javascript at the start of the late javascript so after control setup but before any other late javascript
        self::$late_javascript = self::apply_replacements_to_template($indicia_templates['lock_javascript'], $options).self::$late_javascript;
        self::add_resource('indicia_locks');
      }
    }
    if (strpos($options['attributes'], 'required') !== FALSE) {
      $addons .= self::apply_static_template('requiredsuffix', $options);
    }
    // Add an error icon to the control if there is an error and this option is set
    if ($error && in_array('icon', $options['validation_mode'])) {
      $addons .= $indicia_templates['validation_icon'];
    }
    // If addons are going to be placed after the control, give the template a chance to wrap them together with the
    // main control in an element.
    if ($addons) {
      $r .= self::apply_replacements_to_template($indicia_templates['controlAddonsWrap'], array(
        'control' => $control,
        'addons' => $addons,
      ));
    } else {
      $r .= $control;
    }
    // Label can sometimes be placed after the control.
    if (!empty($options['label']) && isset($options['labelPosition']) && $options['labelPosition'] == 'after') {
    	$r .= $label;
    }
    // Add a message to the control if there is an error and this option is set
    if ($error && in_array('message', $options['validation_mode'])) {
      $r .=  self::apply_error_template($error, $options['fieldname']);
    }

    // Add suffix
    $r .= self::apply_static_template('suffix', $options);

    // If options contain a help text, output it at the end if that is the preferred position
    $r .= self::get_help_text($options, 'after');
    if (isset($options['id']) ) {
      $wrap = empty($options['controlWrapTemplate']) ? $indicia_templates['controlWrap'] : $indicia_templates[$options['controlWrapTemplate']];
      $r = str_replace(array('{control}', '{id}'), array("\n$r", str_replace(':', '-', $options['id'])), $wrap);
    }
    if (!empty($options['tooltip'])) {
      // preliminary support for
      $id = str_replace(':', '\\\\:', array_key_exists('inputId', $options) ? $options['inputId'] : $options['id']);
      $options['tooltip'] = addcslashes($options['tooltip'], "'");
      self::$javascript .= "$('#$id').attr('title', '$options[tooltip]');\n";
    }
    return $r;
  }

 /**
  * Call the enable_validation method to turn on client-side validation for any controls with
  * validation rules defined.
  * To specify validation on each control, set the control's options array
  * to contain a 'validation' entry. This must be set to an array of validation rules in Indicia
  * validation format. For example, 'validation' => array('required', 'email').
  * @param string @form_id Id of the form the validation is being attached to.
  */
  public static function enable_validation($form_id) {
    self::$validated_form_id = $form_id;
    self::$javascript .= "indiciaData.validatedFormId = '" . self::$validated_form_id . "';\n";
    // prevent double submission of the form
    self::$javascript .= "$('#$form_id').submit(function(e) {
  if (typeof $('#$form_id').valid === 'undefined' || $('#$form_id').valid()) {
    if (typeof indiciaData.formSubmitted==='undefined' || !indiciaData.formSubmitted) {
      indiciaData.formSubmitted=true;
    } else {
      e.preventDefault();
      return false;
    }
  }
});\n";
    self::add_resource('validation');
    // Allow i18n on validation messages
    if(lang::get('validation_required') != 'validation_required')
      data_entry_helper::$late_javascript .= "
$.validator.messages.required = \"".lang::get('validation_required')."\";";
    if(lang::get('validation_max') != 'validation_max')
      data_entry_helper::$late_javascript .= "
$.validator.messages.max = $.validator.format(\"".lang::get('validation_max')."\");";
    if(lang::get('validation_min') != 'validation_min')
      data_entry_helper::$late_javascript .= "
$.validator.messages.min = $.validator.format(\"".lang::get('validation_min')."\");";
    if(lang::get('validation_number') != 'validation_number')
      data_entry_helper::$late_javascript .= "
$.validator.messages.number = $.validator.format(\"".lang::get('validation_number')."\");";
    if(lang::get('validation_digits') != 'validation_digits')
      data_entry_helper::$late_javascript .= "
$.validator.messages.digits = $.validator.format(\"".lang::get('validation_digits')."\");";
    if(lang::get('validation_integer') != 'validation_integer')
      data_entry_helper::$late_javascript .= "
$.validator.messages.integer = $.validator.format(\"".lang::get('validation_integer')."\");";
  }

  /**
   * Explodes a value on several lines into an array split on the lines. Tolerates any line ending.
   * @param string $value A multi-line string to be split.
   * @return array An array with one entry per line in $value.
   */
  public static function explode_lines($value) {
    $structure = str_replace("\r\n", "\n", $value);
    $structure = str_replace("\r", "\n", $structure);
    return explode("\n", trim($structure));
  }

  /**
   * Explodes a value with key=value several lines into an array split on the lines. Tolerates any line ending.
   * @param string $value A multi-line string to be split.
   * @return array An associative array with one entry per line in $value. Array keys are the items before the = on each line,
   * and values are the data after the = on each line.
   */
  public static function explode_lines_key_value_pairs($value) {
    preg_match_all("/([^=\r\n]+)=([^\r\n]+)/", $value, $pairs);
    $trim = create_function('&$val', '$val = trim($val);');
    array_walk($pairs[1], $trim);
    array_walk($pairs[2], $trim);
    if (count($pairs[1]) == count($pairs[2]) && count($pairs[1]) != 0) {
      return array_combine($pairs[1], $pairs[2]);
    } else {
      return array();
    }
  }

  /**
   * Utility function to load a list of terms from a termlist.
   * @param array $auth Read authorisation array.
   * @param mixed $termlist Either the id or external_key of the termlist to load.
   * @param array $filter List of the terms that are required, or null for all terms.
   * @return array Output of the Warehouse data services request for the terms.
   * @throws \Exception
   */
  public static function get_termlist_terms($auth, $termlist, $filter=null) {
    if (!is_int($termlist)) {
      $termlistFilter=array('external_key' => $termlist);
      $list = data_entry_helper::get_population_data(array(
        'table' => 'termlist',
        'extraParams' => $auth['read'] + $termlistFilter
      ));
      if (count($list)==0)
        throw new Exception("Termlist $termlist not available on the Warehouse");
      if (count($list)>1)
        throw new Exception("Multiple termlists identified by $termlist found on the Warehouse");
      $termlist = $list[0]['id'];
    }
    $extraParams = $auth['read'] + array(
      'view' => 'detail',
      'termlist_id' => $termlist
    );
    // apply a filter for the actual list of terms, if required.
    if ($filter)
      $extraParams['query'] = urlencode(json_encode(array('in'=>array('term', $filter))));
    $terms = data_entry_helper::get_population_data(array(
      'table' => 'termlists_term',
      'extraParams' => $extraParams
    ));
    return $terms;
  }

 /**
  *  Creates attributes to be added to an output control's element.
  *
  * Converts the validation rules in an options array into attributes which
  * define the rules for the jQuery validation plugin. Also adds the disabled
  * and readonly attributes where indicated in the options.
  *
  * @param $options
  *   Control options array. For validation to be applied should contain a
  *   validation entry, containing a single validation string or an array of
  *   strings.
  *
  * @return string
  *   The validation rules and other attributes which should be added to the
  *   control's output HTML.
  */
  protected static function buildElementAttributes($options) {
    global $custom_terms;
    $options = array_merge([
      'disabled' => FALSE,
      'readonly' => FALSE,
    ], $options);
    $rules = (array_key_exists('validation', $options) ? $options['validation'] : array());
    if (!is_array($rules)) $rules = array($rules);
    if (!empty($options['fieldname']) && array_key_exists($options['fieldname'], self::$default_validation_rules)) {
      $rules = array_merge($rules, self::$default_validation_rules[$options['fieldname']]);
    }
    // Build internationalised validation messages for jQuery to use, if the fields have internationalisation strings specified
    foreach ($rules as $rule) {
      if (isset($custom_terms) && array_key_exists($options['fieldname'], $custom_terms))
        self::$validation_messages[$options['fieldname']][$rule] = sprintf(lang::get("validation_$rule"),
          lang::get($options['fieldname']));
    }
    // Convert these rules into jQuery format.
    $attrs = self::convertToJqueryValMetadata($rules, $options);
    if ($options['disabled']) {
      $attrs[] = 'disabled';
    }
    if ($options['readonly']) {
      $attrs[] = 'readonly';
    }
    return implode(' ', $attrs);
  }

  /**
   * Returns templated help text for a control, but only if the position matches the $helpTextPos value, and
   * the $options array contains a helpText entry.
   * @param array $options Control's options array. Can specify the class for the help text item using option helpTextClass.
   * @param string $pos Either before or after. Defines the position that is being requested.
   * @return string Templated help text, or nothing.
   */
  protected static function get_help_text($options, $pos) {
    $options = array_merge(array('helpTextClass'=>'helpText'), $options);
    if (array_key_exists('helpText', $options) && !empty($options['helpText']) && self::$helpTextPos == $pos) {
      $options['helpText'] = lang::get($options['helpText']);
      return str_replace('{helpText}', $options['helpText'], self::apply_static_template('helpText', $options));
    } else
      return '';
  }

  /**
   * Takes a template string (e.g. <div id="{id}">) and replaces the tokens with the equivalent values looked up from
   * the $options array. Tokens suffixed |escape have HTML escaping applied, e.g. <div id="{id}">{value|escape}</div>
   * @param string $template The templatable string.
   * @param string $options The array of items which can be merged into the template.
   */
  protected static function apply_replacements_to_template($template, $options) {
    // Build an array of all the possible tags we could replace in the template.
    $replaceTags=array();
    $replaceValues=array();
    foreach (array_keys($options) as $option) {
      if (!is_array($options[$option]) && !is_object($options[$option])) {
        array_push($replaceTags, '{'.$option.'}');
        array_push($replaceValues, $options[$option]);
        array_push($replaceTags, '{'.$option.'|escape}');
        array_push($replaceValues, htmlspecialchars($options[$option]));
      }
    }
    return str_replace($replaceTags, $replaceValues, $template);
  }

 /**
  * Takes a list of validation rules in Kohana/Indicia format, and converts them to the jQuery validation
  * plugin metadata format.
  * @param array $rules List of validation rules to be converted.
  * @param array $options Options passed to the validated control.
  *
  * @return string
  *   Text for the attributes and values to add to the element.
  *
  * @todo Implement a more complete list of validation rules.
  */
  protected static function convertToJqueryValMetadata($rules, $options) {
    $converted = array();
    foreach ($rules as $rule) {
      // Detect the rules that can simply be passed through
      $rule = trim($rule);
      $mappings = [
        'required' => ['jqRule' => 'required'],
        'dateISO' => ['jqRule' => 'dateISO'],
        'email' => ['jqRule' => 'email'],
        'url' => ['jqRule' => 'url'],
        'time' => ['jqRule' => 'time'],
        'integer' => ['jqRule' => 'integer'],
        'digit' => ['jqRule' => 'digits'],
        'numeric' => ['jqRule' => 'number'],
        'maximum' => ['jqRule' => 'max', 'valRegEx' => '-?\d+'],
        'minimum' => ['jqRule' => 'min', 'valRegEx' => '-?\d+'],
        'mingridref' => ['jqRule' => 'mingridref', 'valRegEx' => '\d+'],
        'maxgridref' => ['jqRule' => 'maxgridref', 'valRegEx' => '\d+'],
        'regex' => ['jqRule' => 'pattern', 'valRegEx' => '-?\d+'],
      ];
      $arr = explode('[', $rule);
      $ruleName = $arr[0];
      if (!empty($mappings[$ruleName])) {
        $config = $mappings[$ruleName];
        if (isset($config['valRegEx'])) {
          if (preg_match("/$ruleName\[(?P<val>$config[valRegEx])\]/", $rule, $matches)) {
            $converted[] = "$config[jqRule]=\"$matches[val]\"";
          }
        }
        else {
          $converted[] = "$config[jqRule]=\"true\"";
        }
      }
      elseif ($ruleName === 'date' && !isset($options['allowVagueDates']) ||
            (isset($options['allowVagueDates']) && $options['allowVagueDates'] === false)) {
        // Special case for dates where validation disabled when vague dates enabled.
        $converted[] = 'data-rule-customDate=\"true\"';
      }
      elseif ($ruleName === 'length' && preg_match("/length\[(?P<val>\d+(,\d+)?)\]/", $rule, $matches)) {
        // Special case for length Kohana rule which can map to jQuery minlenth
        // and maxlength rules.
        $range = explode(',', $matches['val']);
        if (count($range === 1)) {
          $converted[] = "maxlength=\"$range[0]\"";
        } elseif (count($range === 2)) {
          $converted[] = "minlength=\"$range[0]\"";
          $converted[] = "maxlength=\"$range[1]\"";
        }
      }
    }
    return $converted;
  }

 /**
  * Returns a static template which is either a default template or one specified in the options.
  *
  * @param string $name
  *   The static template type. e.g. prefix or suffix.
  * @param array $options
  *   Array of options which may contain a template name.
  *
  * @return string
  *   Template value.
  */
  public static function apply_static_template($name, $options) {
    global $indicia_templates;
    $key = $name .'Template';
    if (array_key_exists($key, $options)) {
      //a template has been specified
      if (array_key_exists($options[$key], $indicia_templates))
        //the specified template exists
        $template = $indicia_templates[$options[$key]];
      else
        $template = $indicia_templates[$name] .
        '<span class="ui-state-error">Code error: suffix template '.$options[$key].' not in list of known templates.</span>';
    } else {
      //no template specified
      $template = $indicia_templates[$name];
    }
    return self::apply_replacements_to_template($template, $options);
  }

 /**
  * Returns a string where characters have been escaped for use in jQuery selectors
  * @param string $name The string to be escaped.
  * @return string escaped name.
  */
  protected static function jq_esc($name) {
    // not complete, only escapes :[], add other characters as needed.
    $from = array(':','[',']');
    $to = array('\\\\:','\\\\[','\\\\]');
    return $name ? str_replace($from, $to, $name) : $name;
  }

  /**
   * Method to format a control error message inside a templated span.
   * @param string $error The error message.
   * @param string $fieldname The name of the field which the error is being attached to.
   */
  private static function apply_error_template($error, $fieldname) {
    if (empty($error))
      return '';
    global $indicia_templates;
    if (empty($error)) return '';
    $template = str_replace('{class}', $indicia_templates['error_class'], $indicia_templates['validation_message']);
    $template = str_replace('{for}', $fieldname, $template);
    return str_replace('{error}', lang::get($error), $template);
  }

  /**
   * Utility function for external access to the iform cache.
   *
   * @param array $cacheOpts Options array which defines the cache "key", i.e. the unique set of options being cached.
   * @param integer $cacheTimeout Timeout in seconds, if overriding the default cache timeout.
   * @param boolean $random Should a random element be introduced to prevent simultaneous expiry of multiple
   * caches? Default true.
   * @return mixed String read from the cache, or false if not read.
   */
  public static function cache_get($cacheOpts, $cacheTimeout=0, $random=true) {
    if (!$cacheTimeout)
      $cacheTimeout = self::_getCacheTimeOut(array());
    $cacheFolder = self::$cache_folder ? self::$cache_folder : self::relative_client_helper_path() . 'cache/';
    $cacheFile = self::_getCacheFileName($cacheFolder, $cacheOpts, $cacheTimeout);
    $r = self::_getCachedResponse($cacheFile, $cacheTimeout, $cacheOpts, $random);
    return $r === false ? $r : $r['output'];
  }

  /**
   * Utility function for external writes to the iform cache.
   *
   * @param array $cacheOpts Options array which defines the cache "key", i.e. the unique set of options being cached.
   * @param string $toCache String data to cache.
   * @param integer $cacheTimeout Timeout in seconds, if overriding the default cache timeout.
   */
  public static function cache_set($cacheOpts, $toCache, $cacheTimeout=0) {
    if (!$cacheTimeout)
      $cacheTimeout = self::_getCacheTimeOut(array());
    $cacheFolder = self::$cache_folder ? self::$cache_folder : self::relative_client_helper_path() . 'cache/';
    $cacheFile = self::_getCacheFileName($cacheFolder, $cacheOpts, $cacheTimeout);
    self::_cacheResponse($cacheFile, array('output' => $toCache), $cacheOpts);
  }

  /**
   * Wrapped up handler for a cached call to the data or reporting services.
   *
   * @param string $request
   *   Request URL.
   * @param array $options
   *   Control options, which may include a caching option and/or cachePerUser
   *   option.
   *
   * @return mixed
   *   Service call response.
   *
   * @throws \Exception
   */
  protected static function _get_cached_services_call($request, $options) {
    $cacheLoaded = FALSE;
    // allow use of the legacy nocache parameter.
    if (isset($options['nocache']) && $options['nocache'] === TRUE) {
      $options['caching'] = FALSE;
    }
    $useCache = !self::$nocache && !isset($_GET['nocache']) && !empty($options['caching']) && $options['caching'];
    if ($useCache) {
      // Get the URL params, so we know what the unique thing is we are caching.
      $parsedURL = parse_url(self::$base_url . $request);
      parse_str($parsedURL["query"], $cacheOpts);
      unset($cacheOpts['auth_token']);
      unset($cacheOpts['nonce']);
      $cacheOpts['serviceCallPath'] = $parsedURL['path'];
      if (isset($options['cachePerUser']) && !$options['cachePerUser']) {
        unset($cacheOpts['user_id']);
      }
      $cacheFolder = self::$cache_folder ? self::$cache_folder : self::relative_client_helper_path() . 'cache/';
      $cacheTimeOut = self::_getCacheTimeOut($options);
      $cacheFile = self::_getCacheFileName($cacheFolder, $cacheOpts, $cacheTimeOut);
      if ($options['caching']!=='store') {
      	$response = self::_getCachedResponse($cacheFile, $cacheTimeOut, $cacheOpts);
        if ($response !== FALSE)
          $cacheLoaded = TRUE;
      }
    }
    if (!isset($response) || $response===FALSE) {
      $postArgs = null;
      $parsedURL=parse_url(self::$base_url . $request);
      parse_str($parsedURL["query"], $postArgs);
      $url = explode('?', self::$base_url . $request);
      $newURL = array($url[0]);

      $getArgs = array();
      if(isset($postArgs['report'])) { // using the reports rather than direct. If this is case report params go into speial params postarg
        // There is a place in the data services report handling that uses a $_GET on the
        // report parameter, so separate that out from the postargs
        $getArgs[] = 'report=' . $postArgs['report'];
        unset($postArgs['report']);
        // move other REQUESTED fields into POST.
        $postArgs = array('params'=> $postArgs);
        $fieldsToCopyUp = array('reportSource', 'mode', 'auth_token', 'nonce', 'persist_auth', 'filename', 'callback', 'xsl',
              'wantRecords', 'wantColumns', 'wantCount', 'wantParameters', 'knownCount');
        foreach($fieldsToCopyUp as $field) {
          if(isset($postArgs['params'][$field])) {
            $postArgs[$field] = $postArgs['params'][$field];
            unset($postArgs['params'][$field]);
          }
        }
        if(isset($postArgs['params']['user_id'])) {
          // user_id is different as this is used in an explicit _REQUEST in the service_base but
          // also can be proper param to the report - so don't unset.
          $postArgs['user_id'] = $postArgs['params']['user_id'];
        }
        $postArgs['params'] = json_encode((object)$postArgs['params']);
      }

      if(count($getArgs)>0) $newURL[] = implode('&', $getArgs);
      $newURL = implode('?', $newURL);

      $response = self::http_post($newURL, $postArgs);
    }
    $r = json_decode($response['output'], TRUE);
    if (!is_array($r)) {
      $response['request'] = $request;
      throw new Exception('Invalid response received from Indicia Warehouse. '.print_r($response, TRUE));
    }
    // Only cache valid responses and when not already cached
    if ($useCache && !isset($r['error']) && !$cacheLoaded) {
      self::_cacheResponse($cacheFile, $response, $cacheOpts, $options['caching']==='store');
    }
    self::_purgeCache();
    self::_purgeImages();
    return $r;
  }

  /**
   * Protected function to fetch a validated timeout value from passed in options array.
   *
   * @param array $options Options array with the following possibilities:
   * * **cachetimeout** - Optional. The length in seconds before the cache times out and is refetched.
   * @return Timeout in number of seconds, else FALSE if data is not to be cached.
   */
  protected static function _getCacheTimeOut($options)
  {
    if (is_numeric(self::$cache_timeout) && self::$cache_timeout > 0) {
      $ret_value = self::$cache_timeout;
    } else {
      $ret_value = false;
    }
    if (isset($options['cachetimeout'])) {
      if (is_numeric($options['cachetimeout']) && $options['cachetimeout'] > 0) {
        $ret_value = $options['cachetimeout'];
      } else {
        $ret_value = false;
      }
    }
    return $ret_value;
  }

  /**
   * Protected function to generate a filename to be used as the cache file for this data
   * @param string $path directory path for file
   * @param array $options Options array : contents are used along with md5 to generate the filename.
   * @param integer $timeout - will be false if no caching to take place
   * @return string filename, else FALSE if data is not to be cached.
   */
  protected static function _getCacheFileName($path, $options, $timeout)
  {
    /* If timeout is not set, we're not caching */
    if (!$timeout)
      return false;
    if(!is_dir($path) || !is_writeable($path))
      return false;

    $cacheFileName = $path.'cache_'.self::$website_id.'_';
    $cacheFileName .= md5(self::array_to_query_string($options));

    return $cacheFileName;
  }

  /**
   * Protected function to return the cached data stored in the specified local file.
   *
   * @param string $file
   *   Cache file to be used, includes path.
   * @param integer $timeout
   *   Will be false if no caching to take place.
   * @param array $options
   *   Options array : contents used to confirm what this data is.
   * @param boolean $random
   *   Should a random element be introduced to prevent simultaneous expiry of multiple
   *   caches? Default true.
   *
   * @return array
   *   Equivalent of call to http_post, else FALSE if data is not to be cached.
   */
  protected static function _getCachedResponse($file, $timeout, $options, $random=true) {
    // Note the random element, we only timeout a cached file sometimes.
    $wantToCache = $timeout !== false;
    $haveFile = $file && is_file($file);
    $fresh = $haveFile && filemtime($file) >= (time() - $timeout);
    $randomSurvival = $random && (rand(1, self::$cache_chance_refresh_file)!==1);
    if ($wantToCache && $haveFile && ($fresh || $randomSurvival)) {
      $response = array();
      $handle = fopen($file, 'rb');
      if (!$handle) {
        return false;
      }
      $tags = fgets($handle);
      $response['output'] = fread($handle, filesize($file));
      fclose($handle);
      if ($tags == self::array_to_query_string($options)."\n") {
        return($response);
      }
    } else {
      self::_timeOutCacheFile($file, $timeout);
    }
    return false;
  }

  /**
   * Protected function to remove a cache file if it has timed out.
   *
   * @param string $file
   *   Cache file to be removed, includes path
   * @param number $timeout
   *   Will be false if no caching to take place.
   */
  protected static function _timeOutCacheFile($file, $timeout) {
    if ($file && is_file($file) && filemtime($file) < (time() - $timeout)) {
      unlink($file);
    }
  }

  /**
   * Protected function to create a cache file provided it does not already exist.
   * @param string $file Cache file to be removed, includes path - will be false if no caching to take place
   * @param array $response http_post return value
   * @param array $options Options array : contents used to tag what this data is.
   */
  protected static function _cacheResponse($file, $response, $options, $force=false)
  {
    // need to create the file as a binary event - so create a temp file and move across.
    if ($file && (!is_file($file) || $force) && isset($response['output'])) {
      $handle = fopen($file.getmypid(), 'wb');
      fputs($handle, self::array_to_query_string($options)."\n");
      fwrite($handle, $response['output']);
      fclose($handle);
      rename($file.getmypid(),$file);
    }
  }

  /**
   * Helper function to clear the Indicia cache files.
   */
  public static function clear_cache() {
    $cacheFolder = self::$cache_folder ? self::$cache_folder : self::relative_client_helper_path() . 'cache/';
    if(!$dh = @opendir($cacheFolder)) {
      return;
    }
    while (false !== ($obj = readdir($dh))) {
      if($obj != '.' && $obj != '..')
        @unlink($cacheFolder . '/' . $obj);
    }
    closedir($dh);
  }

  /**
   * Internal function to ensure old cache files are purged periodically.
   */
  protected static function _purgeCache() {
    $cacheFolder = self::$cache_folder ? self::$cache_folder : self::relative_client_helper_path() . 'cache/';
    self::purgeFiles(self::$cache_chance_purge, $cacheFolder, self::$cache_timeout * 5, self::$cache_allowed_file_count);
  }

  /**
   * Internal function to ensure old image files are purged periodically.
   */
  protected static function _purgeImages() {
    self::purgeFiles(self::$cache_chance_purge, self::getInterimImageFolder(), self::$interim_image_expiry);
  }

  /**
   * Performs a periodic purge of cached or interim image upload files.
   * @param integer $chanceOfPurge Indicates the chance of a purge happening. 1 causes a purge
   * every time the function is called, 10 means there is a 1 in 10 chance, etc.
   * @param string $folder Path to the folder to purge cache files from.
   * @param integer $timeout Age of files in seconds before they will be considered for
   * purging.
   * @param integer $allowedFileCount Number of most recent files to not bother purging
   * from the cache.
   */
  private static function purgeFiles($chanceOfPurge, $folder, $timeout, $allowedFileCount=0) {
    // don't do this every time.
    if (TRUE || rand(1, $chanceOfPurge)===1) {
      // First, get an array of files sorted by date
      $files = array();
      $dir =  opendir($folder);
      // Skip certain file names
      $exclude = array('.', '..', '.htaccess', 'web.config', '.gitignore');
      if ($dir) {
        while ($filename = readdir($dir)) {
          if (is_dir($filename) || in_array($filename, $exclude))
            continue;
          $lastModified = filemtime($folder . $filename);
          $files[] = array($folder .$filename, $lastModified);
        }
      }
      // sort the file array by date, oldest first
      usort($files, array('helper_base', 'DateCmp'));
      // iterate files, ignoring the number of files we allow in the cache without caring.
      for ($i=0; $i<count($files)-$allowedFileCount; $i++) {
        // if we have reached a file that is not old enough to expire, don't go any further
        if ($files[$i][1] > (time() - $timeout)) {
          break;
        }
        // clear out the old file
        if (is_file($files[$i][0]))
          unlink($files[$i][0]);
      }
    }
  }


  /**
   * A custom PHP sorting function which uses the 2nd element in the compared array to
   * sort by. The sorted array normally contains a list of files, with the first element
   * of each array entry being the file path and the second the file date stamp.
   * @param int $a Datestamp of the first file to compare.
   * @param int $b Datestamp of the second file to compare.
   */
  private static function DateCmp($a, $b)
  {
    if ($a[1]<$b[1])
      $r = -1;
    else if ($a[1]>$b[1])
      $r = 1;
    else $r=0;
    return $r;
  }

}

/**
 * For PHP 5.2, declare the get_called_class method which allows us to use subclasses of this form.
 */
if(!function_exists('get_called_class')) {
  function get_called_class() {
    $matches=array();
    $bt = debug_backtrace();
    $l = 0;
    do {
        $l++;
        if(isset($bt[$l]['class']) AND !empty($bt[$l]['class'])) {
            return $bt[$l]['class'];
        }
        $lines = file($bt[$l]['file']);
        $callerLine = $lines[$bt[$l]['line']-1];
        preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/',
                   $callerLine,
                   $matches);
        if (!isset($matches[1])) $matches[1]=NULL; //for notices
        if ($matches[1] == 'self') {
               $line = $bt[$l]['line']-1;
               while ($line > 0 && strpos($lines[$line], 'class') === false) {
                   $line--;
               }
               preg_match('/class[\s]+(.+?)[\s]+/si', $lines[$line], $matches);
       }
    }
    while ($matches[1] == 'parent'  && $matches[1]);
    return $matches[1];
  }
}

// If a helper_config class is specified, then copy over the settings.
if (class_exists('helper_config')) {
  if (isset(helper_config::$base_url)) {
    helper_base::$base_url = helper_config::$base_url;
  }
  if (isset(helper_config::$warehouse_proxy)) {
    helper_base::$warehouse_proxy = helper_config::$warehouse_proxy;
  }
  if (isset(helper_config::$geoserver_url)) {
    helper_base::$geoserver_url = helper_config::$geoserver_url;
  }
  if (isset(helper_config::$interim_image_folder)) {
    helper_base::$interim_image_folder = helper_config::$interim_image_folder;
  }
  if (isset(helper_config::$google_api_key)) {
    helper_base::$google_api_key = helper_config::$google_api_key;
  }
  if (isset(helper_config::$google_maps_api_key)) {
    helper_base::$google_maps_api_key = helper_config::$google_maps_api_key;
  }
  if (isset(helper_config::$bing_api_key)) {
    helper_base::$bing_api_key = helper_config::$bing_api_key;
  }
  if (isset(helper_config::$os_api_key)) {
    helper_base::$os_api_key = helper_config::$os_api_key;
  }
  if (isset(helper_config::$delegate_translation_to_hostsite)) {
    helper_base::$delegate_translation_to_hostsite = helper_config::$delegate_translation_to_hostsite;
  }
}