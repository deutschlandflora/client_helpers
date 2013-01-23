<?php
/**
 * Indicia, the OPAL Online Recording Toolkit.
 * extends iform_dynamic_sample_occurrence
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
 * @package    Client
 * @subpackage PrebuiltForms
 * @author    Indicia Team
 * @license    http://www.gnu.org/licenses/gpl.html GPL 3.0
 * @link     http://code.google.com/p/indicia/
 */

/**
 * Prebuilt Indicia data entry form for WWT Colour-marked wildfowl.
 * NB has Drupal specific code. Relies on presence of IForm loctools and IForm Proxy.
 * NB relies on the individuals and associations optional module being enabled in the warehouse.
 * 
 * @package    Client
 * @subpackage PrebuiltForms
 * @link http://code.google.com/p/indicia/wiki/PrebuiltFormWWTColourMarkedRecords
 */

require_once('dynamic_sample_occurrence.php');
require_once('includes/map.php');
require_once('includes/language_utils.php');
require_once('includes/form_generation.php');
require_once('includes/individuals.php');

class iform_wwt_age_assessment  extends iform_dynamic_sample_occurrence{

  // A list of the subject observation ids we are loading if editing existing data
  protected static $subjectObservationIds = array();
  protected static $loadedSubjectObservationId;
  protected static $loadedSampleId;
  protected static $auth = array();
  protected static $mode;
  protected static $node;
  // The class called by iform.module which may be a subclass of iform_location_dynamic



  
  protected static $submission = array();
  /** 
   * Return the form metadata.
   * @return string The definition of the form.
   */

  public static function get_wwt_age_assessment_definition() {
    return array(
      'title'=>'RFJ WWT Age Assessment form',
      'category' => 'General Purpose Data Entry Forms',
      'helpLink'=>'http://code.google.com/p/indicia/wiki/PrebuiltFormWWTColourMarkedRecords',
      'description'=>'A data entry form reporting observations of colour-marked individual birds.'
    );
  }

}
