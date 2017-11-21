<?php

/**
 * @file
 * Extension class that assists in printable output generation.
 *
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
 * @package Client
 * @subpackage PrebuiltForms
 * @author Indicia Team
 * @license http://www.gnu.org/licenses/gpl.html GPL 3.0
 * @link http://code.google.com/p/indicia/
 */

/**
 * Extension class that assists in printable output generation.
 */
class extension_print {

  /**
   * Button for converting a page to a PDF file.
   *
   * Allows a report page to be output into PDF format. Does not currently support maps.
   *
   * @param array $auth
   *   Authorisation tokens.
   * @param array $args
   *   Form arguments.
   * @param string $tabalias
   *   ID of the tab being loaded onto.
   * @param array $options
   *   Options passed to the control. Options are:
   *     * format - portrait, landscape, or choose (default).
   * @param string $path
   *   Current page path.
   *
   * @return string
   *   Control HTML to embed in page.
   */
  public static function pdf(array $auth, array $args, $tabalias, array $options, $path) {
    global $indicia_templates;
    helper_base::add_resource('html2pdf');
    helper_base::add_resource('fancybox');
    $options = array_merge(array(
      'format' => 'choose',
    ), $options);
    $lang = array(
      'ConvertPageToPDF' => lang::get('Convert page to PDF'),
      'PDFOptions' => lang::get('PDF options'),
    );
    if ($options['format'] === 'portrait' || $options['format'] === 'landscape') {
      return <<<HTML
<input name="pdf-format" value="$options[format]" />
<button id="convert-to-pdf" type="button">$lang[ConvertPageToPDF]</button>
HTML;
    }
    else {
      $select = data_entry_helper::select(array(
        'id' => 'pdf-format',
        'label' => lang::get('Format'),
        'lookupValues' => array(
          'portrait' => lang::get('Portrait'),
          'landscape' => lang::get('Landscape'),
        ),
      ));
      $generateBtn = helper_base::apply_static_template('button', array(
        'id' => 'convert-to-pdf',
        'title' => lang::get('Generate a PDF file from the current page.'),
        'class' => ' class="' . $indicia_templates['buttonHighlightedClass'] . '"',
        'caption' => lang::get('Generate PDF'),
      ));
      $cancelBtn = helper_base::apply_static_template('button', array(
        'id' => 'pdf-options-cancel',
        'title' => lang::get('Cancel generating a PDF file.'),
        'class' => ' class="' . $indicia_templates['buttonDefaultClass'] . '"',
        'caption' => lang::get('Cancel'),
      ));
      return <<<HTML
<button id="show-pdf-options" type="button">$lang[ConvertPageToPDF]</button>
<div id="pdf-options" style="display: none">
  <fieldset>
    <legend>$lang[PDFOptions]</legend>
    $select
  </fieldset>
  $generateBtn
  $cancelBtn
</div>
HTML;
    }
  }

}