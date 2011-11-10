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
 * @package	Client
 * @subpackage PrebuiltForms
 * @author	Indicia Team
 * @license	http://www.gnu.org/licenses/gpl.html GPL 3.0
 * @link 	http://code.google.com/p/indicia/
 */
/*
 * Options: includeParentLookUp
 * 			loctoolsLocTypeID
 * 			usePolygons
 * 			LocationTypeID
 * 			includeLocationComment
 * 			includeLocationCode
 * 
 * TBD extend locModTool to process any location attributes
 * TBD extend locModTool to return to locations page after saving.
 * TBD extend to process point sites.
 */
function iform_mnhnl_getParameters() {
  return
      array(
        array(
          'name'=>'includeParentLookUp',
          'caption'=>'Include Parent Lookup for locations',
          'description'=>'In the Tool to modify locations, include a field to lookup the parent_id',
          'type'=>'boolean',
          'default' => true,
          'required' => false,
          'group' => 'Locations'
        ),
        array(
          'name'=>'usePolygons',
          'caption'=>'Use Polygons for locations',
          'description'=>'Describes geometry used for locations generated by form: uncheck for points',
          'type'=>'boolean',
          'default' => true,
          'required' => false,
          'group' => 'Locations'
        ),
        array(
          'name'=>'LocationTypeID',
          'caption'=>'Site Location Type ID filter',
          'description'=>'Location Type ID for locations which are Sites ',
          'type'=>'int',
          'required' => true,
          'group' => 'Locations'
        ),
        array(
          'name'=>'includeLocationComment',
          'caption'=>'Include Location Comment when viewing location data',
          'description'=>'Choose whether to include the location comment in the list of fields which can be modified by the Locations Modification Tool.',
          'type'=>'boolean',
          'default' => true,
          'required' => false,
          'group' => 'Locations'
        ),
        array(
          'name'=>'includeLocationCode',
          'caption'=>'Include Location Code when viewing location data',
          'description'=>'Choose whether to include the location code in the list of fields which can be modified by the Locations Modification Tool.',
          'type'=>'boolean',
          'default' => true,
          'required' => false,
          'group' => 'Locations'
        ),
        array(
          'name'=>'multiSite',
          'caption'=>'Include Multiple Sites attached to this sample',
          'description'=>'Activate when you wish to access multiple sites at once against the main sample. This implies that the sample will have one or more subsamples, one for each site.',
          'type'=>'boolean',
          'default' => false,
          'required' => false,
          'group' => 'Locations'
        ),
        array(
          'name'=>'AllowChangeOfLocation',
          'caption'=>'Allow Change Of Location',
          'description'=>'Allow the main location to be changed when modifying an existing location.',
          'type'=>'boolean',
          'default' => false,
          'required' => false,
          'group' => 'Locations'
        ),
        array(
          'name'=>'siteNameTermListID',
          'caption'=>'Use Termlist for Site Names',
          'description'=>'Use this termlist ID for the site names. Omit to allow text entry.',
          'type'=>'int',
          'required' => false,
          'group' => 'Locations'
        ));
}

function iform_mnhnl_locModTool($auth, $args) {
  global $indicia_templates;
  if (!isset($args['usePolygons'])) return "iform_mnhnl_locModTool: usePolygons not set.";
  if (!isset($args['LocationTypeID'])) return "iform_mnhnl_locModTool: LocationTypeID not set.";
  $retVal = '<div id="locations" ><p>'.lang::get("LANG_LocModTool_Instructions1").'</p>';
    $retVal .= "<form method=\"post\" id=\"entry_form\">".
          $auth['write'].
          "<input type=\"hidden\" id=\"source\" name=\"source\" value=\"iform_mnhnl_locModTool\" />".
          "<input type=\"hidden\" id=\"website_id\" name=\"website_id\" value=\"".$args['website_id']."\" />".
          "<input type=\"hidden\" id=\"survey_id\" name=\"survey_id\" value=\"".$args['survey_id']."\" />";
    // at this point we assume that this admin user has access to all locations.
    if(isset($args['includeParentLookUp']) && $args['includeParentLookUp']){
      if (!isset($args['loctoolsLocTypeID'])) return "iform_mnhnl_locModTool: includeParentLookUp set, loctoolsLocTypeID not set.";
      $locOptions = array('validation' => array('required'),
    					'label'=>lang::get('LANG_LocModTool_ParentLabel'),
    					'id'=>'parent_id',
    					'table'=>'location',
    					'fieldname'=>'location:parent_id',
    					'valueField'=>'id',
    					'captionField'=>'name',
    					'template' => 'select',
    					'itemTemplate' => 'select_item',
    					'extraParams'=>array_merge($auth['read'],
    						array('parent_id'=>'NULL',
    								'view'=>'detail',
    								'orderby'=>'name',
    								'location_type_id'=>$args['loctoolsLocTypeID'],
    								'deleted'=>'f')));
      $response = data_entry_helper::get_population_data($locOptions);
      if (isset($response['error'])) return "PARENT LOOKUP ERROR:  ".$response['error'];
      $opts .= str_replace(array('{value}', '{caption}', '{selected}'),
                         array('', htmlentities(lang::get('LANG_LocModTool_ParentBlank')), ''),
                         $indicia_templates[$locOptions['itemTemplate']]);
      foreach ($response as $record) {
      	$caption = htmlspecialchars($record[$locOptions['captionField']]);
        $opts .= str_replace(array('{value}', '{caption}', '{selected}'),
                               array($record[$locOptions['valueField']],
                                     htmlentities($record[$locOptions['captionField']]), ''),
                               $indicia_templates[$locOptions['itemTemplate']]);
      }
      $locOptions['items'] = $opts;
      $retVal .= data_entry_helper::apply_template($locOptions['template'], $locOptions);
    } else return "iform_mnhnl_locModTool: includeParentLookUp not set."; // TBD
    $retVal .= '<p>'.lang::get("LANG_LocModTool_Instructions2")."</p>
  <label for=\"location-id\">".lang::get("LANG_LocModTool_IDLabel")." : </label><select id=\"location-id\" name=\"location:id\" class='required'><option >".((isset($args['includeParentLookUp']) && $args['includeParentLookUp']) ? lang::get("LANG_ChooseParentFirst") : lang::get("LANG_EmptyLocationID"))."</option></select><br />";
    if($args['siteNameTermListID']== '') {
      $retVal .= "<label for=\"location-name\">".lang::get("LANG_LocModTool_NameLabel")." : </label><input id=\"location-name\" name=\"location:name\" class='required'><br />";
    } else {
      $retVal .= data_entry_helper::select(array(
        'label'=>lang::get("LANG_LocModTool_NameLabel"),
        'id'=>'location-name',
        'fieldname'=>'location:name',
        'table'=>'termlists_term',
        'captionField'=>'term',
        'valueField'=>'term',
        'extraParams' => $auth['read'] + array('termlist_id'=>$args['siteNameTermListID'], 'orderby'=>'id')
    ));
    }
    $retVal .= "<label for=\"location-delete\">".lang::get("LANG_LocModTool_DeleteLabel")." : </label><input type=checkbox id=\"location-delete\" name=\"location:deleted\" value='t'><br />
  <p>".lang::get("LANG_LocModTool_DeleteInstructions")."</p>
  <input type=\"hidden\" id=\"centroid_sref\" name=\"location:centroid_sref\" readonly=\"readonly\" >
  <input type=\"hidden\" id=\"centroid_sref_system\" name=\"location:centroid_sref_system\" readonly=\"readonly\" >
  <input type=\"hidden\" id=\"centroid_geom\" name=\"location:centroid_geom\" readonly=\"readonly\" >
  <input type=\"hidden\" id=\"boundary_geom\" name=\"location:boundary_geom\" readonly=\"readonly\" >";
    if(isset($args['includeLocationComment']) && $args['includeLocationComment'])
    	$retVal .= "<label for=\"location-comment\">".lang::get("LANG_LocationModTool_CommentLabel")." : </label><input id=\"location-comment\" name=\"location:comment\"><br />";
    if(isset($args['includeLocationCode']) && $args['includeLocationCode'])
    	$retVal .= "<label for=\"location-code\">".lang::get("LANG_LocationModTool_CodeLabel")." : </label><input id=\"location-code\" name=\"location:code\"><br />";
    $retVal .= "<label for=\"imp-srefX\" class=\"auto-width\" >".lang::get('LANG_Location_X_Label').":</label><input type=\"text\" id=\"imp-srefX\" name=\"dummy:srefX\"  disabled=\"disabled\"/>
<label for=\"imp-srefX\" class=\"auto-width prepad\" >".lang::get('LANG_Location_Y_Label').":</label><input type=\"text\" id=\"imp-srefY\" name=\"dummy:srefY\" disabled=\"disabled\"/><span id=\"coords-text\" class=\"coords-text\">".lang::get('LANG_LatLong_Bumpf')."</span><br />";
    if(isset($args['includeParentLookUp']) && $args['includeParentLookUp'])
      $retVal .= iform_mnhnl_locationButtonsControl($args, true, false);
    /* TBD Poss convert this to AJAX */
    /* TDB Location Attributes : neither reptiles nor butterflies2 have location attributes*/
    // location ID is fixed and correct: don't include in form
    // For main page we force to Tabs to ensure map drawn correctly
    $args['interface']='Tabs';
    $mapOptions = iform_map_get_map_options($args,$readAuth);
    $olOptions = iform_map_get_ol_options($args);
    $mapOptions['tabDiv'] = 'locations';
    $mapOptions['standardControls']=array('layerSwitcher','panZoom','modFeature');
    $mapOptions['layers']=array("ParentLocationLayer","SiteListLayer");
    $mapOptions['editLayer']=false;
    $retVal .= data_entry_helper::map_panel($mapOptions, $olOptions);
    $retVal .= '<input type="submit" class="ui-state-default ui-corner-all" value="'.lang::get('LANG_Submit').'">
    </form></div>';
    iform_mnhnl_setCommonLayers();
    data_entry_helper::$javascript .= "
function onFeatureSelected(evt) {
  feature = evt.feature;
  SiteListLayer.map.zoomToExtent(feature.geometry.getBounds());
  jQuery('#location-id').val(feature.attributes.id);";
    if($args['siteNameTermListID']!= '')
      data_entry_helper::$javascript .= "
  jQuery('#location-name').find('option').attr('disabled','');
  for(var i=0; i< SiteListLayer.features.length; i++){
    if(typeof SiteListLayer.features[i].attributes.id != 'undefined' && feature.attributes.id != SiteListLayer.features[i].attributes.id) 
      jQuery('#location-name').find('option').filter('[value='+SiteListLayer.features[i].attributes.name+']').attr('disabled','disabled');
  }";
    data_entry_helper::$javascript .= "
  jQuery('#location-name').val(feature.attributes.name);
  jQuery('#centroid_sref').val(feature.attributes.centroid_sref);
  if (feature.attributes.centroid_sref.indexOf(' ')!==-1) {
    var parts=feature.attributes.centroid_sref.split(' ');
    parts[0]=parts[0].split(',')[0]; // part 1 may have a comma at the end, so remove
    $('#imp-srefX').val(parts[0]);
    $('#imp-srefY').val(parts[1]);
  } else $('#imp-srefX,#imp-srefY').val('NA');
  jQuery('#centroid_sref_system').val(feature.attributes.centroid_sref_system);
  jQuery('#centroid_geom').val(feature.attributes.centroid_geom);
  jQuery('#boundary_geom').val(feature.attributes.boundary_geom);
  jQuery('#location-comment').val(feature.attributes.comment);
  jQuery('#location-code').val(feature.attributes.code);
}
function onFeatureAdded(evt) {
  if(typeof modFeature == 'undefined'){
    modFeature = new OpenLayers.Control.ModifyFeature(SiteListLayer);
    SiteListLayer.map.addControl(modFeature);
    modFeature.activate();
  }
}
function onFeatureModified(evt) {
  feature = evt.feature;
  wkt = '';
  points = feature.geometry.components[0].getVertices();
  if(points.length < 3){
    alert('".lang::get('LANG_TooFewPoints')."');
    return;
  }
  centre = feature.geometry.getCentroid();
  if(!ParentLocationLayer.features[0].geometry.intersects(centre))
    alert('".lang::get('LANG_CentreOutsideParent')."');
  for(var i = 0; i< points.length; i++)
    wkt = wkt+(i==0? '' : ', ')+points[i].x+' '+points[i].y;
  wkt = wkt+', '+points[0].x+' '+points[0].y;
  jQuery('#boundary_geom').val(\"POLYGON((\" + wkt + \"))\");
  jQuery('#centroid_geom').val(\"POINT(\" + centre.x + \"  \" + centre.y + \")\");
  jQuery.getJSON(\"".data_entry_helper::$base_url."/index.php/services/spatial/wkt_to_sref?wkt=POINT(\" + centre.x + \"  \" + centre.y + \")&system=2169&precision=8&callback=?\",
    function(data){
      if(typeof data.error != 'undefined')
        alert(data.error);
      else {
        jQuery('#centroid_sref').val(data.sref);
        var parts=data.sref.split(' ');
        parts[0]=parts[0].split(',')[0]; // part 1 may have a comma at the end, so remove
        $('#imp-srefX').val(parts[0]);
        $('#imp-srefY').val(parts[1]);
      }
  });
}
SiteListLayer.events.on({
    'featureadded': onFeatureAdded,
    'featureselected': onFeatureSelected,
    'featuremodified': onFeatureModified
  });
loadFeatures = function(parent_id){
  ParentLocationLayer.destroyFeatures();
  SiteListLayer.destroyFeatures();
  jQuery('#location-id').val('');
  jQuery('#location-name').val('');
  jQuery('#centroid_sref').val('');
  $('#imp-srefX,#imp-srefY').val('');
  jQuery('#centroid_geom').val('');
  jQuery('#boundary_geom').val('');
  jQuery('#location-id').find('option').remove();
  jQuery('#location-comment').val('');
  jQuery('#location-code').val('');
  if(parent_id != ''){
    jQuery('#location-id').append('<option>".lang::get("LANG_EmptyLocationID")."</option>');
    jQuery.getJSON(\"".data_entry_helper::$base_url."/index.php/services/data/location/\"+parent_id+\"?mode=json&view=detail&auth_token=".$auth['read']['auth_token']."&nonce=".$auth['read']["nonce"]."&callback=?\",
      function(data) {
       if (data.length>0) {
         var parser = new OpenLayers.Format.WKT();
         if(data[0].boundary_geom){ // only one location if any
           feature = parser.read(data[0].boundary_geom)
           ParentLocationLayer.addFeatures([feature]);
           ParentLocationLayer.map.zoomToExtent(ParentLocationLayer.getDataExtent());
         }
       }});
    jQuery.getJSON(\"".data_entry_helper::$base_url."/index.php/services/data/location?mode=json&view=detail&auth_token=".$auth['read']['auth_token']."&nonce=".$auth['read']["nonce"]."&callback=?&orderby=id&location_type_id=".$args['LocationTypeID']."&parent_id=\"+parent_id,
      function(data) {
        if (data.length>0) {
          var parser = new OpenLayers.Format.WKT();
          for (var i=0;i<data.length;i++){
            if(data[i].boundary_geom){
              jQuery('<option value=\"'+data[i].id+'\">'+data[i].name+'</option>').appendTo('#location-id');
              feature = parser.read(data[i].boundary_geom); // assume map projection=900913
              feature.attributes = data[i];
              feature.attributes.new=false;
              if(data[i].centroid_geom){
                centrefeature = parser.read(data[i].centroid_geom); // assume map projection=900913
                centrefeature.style = {label: data[i].name};
              } else {
                centre = feature.geometry.getCentroid();
                centrefeature = new OpenLayers.Feature.Vector(centre, {}, {label: data[i].name});
              }
              centrefeature.attributes.new=false;
              SiteListLayer.addFeatures([feature, centrefeature]);
            }}}});
  } else 
    jQuery('#location-id').append('<option>".lang::get("LANG_ChooseParentFirst")."</option>');
}
jQuery('#location-id').change(function() {
  for(var i=0; i<SiteListLayer.features.length; i++){
    if(SiteListLayer.features[i].attributes.id == $(this).val()){
      modFeature.selectControl.select(SiteListLayer.features[i]);
      break;
    }
  }
});
jQuery(\"#parent_id\").change(function(){
  loadFeatures(this.value);
});
jQuery(\"#parent_id\").val('').change();";
    return $retVal;
  }

function iform_mnhnl_setCommonLayers() {
     data_entry_helper::$javascript .= "
// Create vector layers: one to display the Parent Square onto, and another for the site locations list
// the default edit layer is used for this sample
ParentLocStyleMap = new OpenLayers.StyleMap({\"default\": new OpenLayers.Style({strokeColor: \"Yellow\",fillOpacity: 0,strokeWidth: 4})});
ParentLocationLayer = new OpenLayers.Layer.Vector('Parents',{styleMap: ParentLocStyleMap,displayInLayerSwitcher: false});
defaultStyle = new OpenLayers.Style({pointRadius: 3,fillColor: \"Red\",fillOpacity: 0.3,strokeColor: \"Red\",strokeWidth: 1});
selectStyle = new OpenLayers.Style({pointRadius: 3,fillColor: \"Blue\",fillOpacity: 0.2,strokeColor: \"Blue\",strokeWidth: 2});
SiteLocStyleMap = new OpenLayers.StyleMap({\"default\": defaultStyle, \"select\": selectStyle});
SiteListLabelStyleHash = {fontColor: \"Yellow\"};
SiteListNewStyleHash = {fontColor: \"Yellow\", pointRadius: 3, fillColor: \"Blue\",fillOpacity: 0.3,strokeColor: \"Red\",strokeWidth: 1};
SiteListLayer = new OpenLayers.Layer.Vector('Sites',{styleMap: SiteLocStyleMap,displayInLayerSwitcher: false});
";
}

function iform_mnhnl_recordernamesControl($node, $auth, $args, $tabalias, $options) {
    $values = array();
  	$userlist = array();
    $results = db_query('SELECT uid, name FROM {users}');
    while($result = db_fetch_object($results)){
    	$account = user_load($result->uid);
    	if($account->uid != 1 && user_access('IForm n'.$node->nid.' user', $account)){
			$userlist[$result->name] = $result->name;
		}
    }
    if (isset(data_entry_helper::$entity_to_load['sample:recorder_names'])){
      if(!is_array(data_entry_helper::$entity_to_load['sample:recorder_names']))
        $values = explode("\r\n", data_entry_helper::$entity_to_load['sample:recorder_names']);
      else
        $values = data_entry_helper::$entity_to_load['sample:recorder_names'];
    }
    foreach($values as $value){
      $userlist[$value] = $value;
    }
    $r = data_entry_helper::listbox(array_merge(array(
      'id'=>'sample:recorder_names',
      'fieldname'=>'sample:recorder_names[]',
      'label'=>lang::get('Recorder names'),
      'size'=>6,
      'multiselect'=>true,
      'default'=>$values,
      'lookupValues'=>$userlist
      ,'validation'=>array('required')
    ), $options));
    return $r."<span>".lang::get('LANG_RecorderInstructions')."</span><br />";
  }

function iform_mnhnl_lux5kgridControl($auth, $args, $tabalias, $options, $node, $config) {
    /*
     * TBD put in check to enforce ParentLocationType and LocationType in options, loctools set?
     * The location centroid sref will contain the central point of the geom.
     */
    global $indicia_templates, $user;
    if(isset(data_entry_helper::$entity_to_load["sample:updated_by_id"])) // only set if data loaded from db, not error condition
      data_entry_helper::load_existing_record($auth['read'], 'location', data_entry_helper::$entity_to_load["sample:location_id"]);
    iform_mnhnl_setCommonLayers();
    data_entry_helper::$javascript .= "
loadFeatures = function(parent_id, child_id, childArgs){
  ParentLocationLayer.destroyFeatures();
  SiteListLayer.destroyFeatures();
  jQuery(\"#sample_location_id\").empty();
  if(parent_id != ''){
    jQuery(\"#sample_location_id\").append('<option >".lang::get("LANG_EmptyLocationID")."</option>');
    jQuery.getJSON(\"".data_entry_helper::$base_url."/index.php/services/data/location/\"+parent_id+\"?mode=json&view=detail&auth_token=".$auth['read']['auth_token']."&nonce=".$auth['read']["nonce"]."&callback=?\",
      function(data) {
       if (data.length>0) {
         var parser = new OpenLayers.Format.WKT();
         if(data[0].boundary_geom){ // only one location if any
           feature = parser.read(data[0].boundary_geom)
           ParentLocationLayer.addFeatures([feature]);
           if(child_id == '') ParentLocationLayer.map.zoomToExtent(ParentLocationLayer.getDataExtent());
         }
".($args['multiSite'] ? "  jQuery('#smp-loc-name').val(data[0].name);" : "")."
       }});
    jQuery.getJSON(\"".data_entry_helper::$base_url."/index.php/services/data/location?mode=json&view=detail&auth_token=".$auth['read']['auth_token']."&nonce=".$auth['read']["nonce"]."&callback=?&orderby=id&location_type_id=".$args['LocationTypeID']."&parent_id=\"+parent_id,
      function(data) {
        if (data.length>0) {
          var parser = new OpenLayers.Format.WKT();
          for (var i=0;i<data.length;i++){
            if(data[i].boundary_geom){
              feature = parser.read(data[i].boundary_geom); // assume map projection=900913
              feature.attributes.id = data[i].id;
              feature.attributes.boundary = data[i].boundary_geom;
              feature.attributes.centroid = data[i].centroid_geom;
              feature.attributes.sref = data[i].centroid_sref;
              feature.attributes.name = data[i].name;
              feature.attributes.new=false;
              if(data[i].centroid_geom){
                centrefeature = parser.read(data[i].centroid_geom); // assume map projection=900913
              } else {
                centre = feature.geometry.getCentroid();
                centrefeature = new OpenLayers.Feature.Vector(centre);
              }
              centrefeature.attributes.new=false;
              centrefeature.style = jQuery.extend({}, SiteListLabelStyleHash);".(isset($config['extendName']) ? "
              if(data[i].".$config['extendName'].")
                centrefeature.style.label = data[i].name".(isset($config['extendName']) ? "+\" (\"+data[i].".$config['extendName']."+\")\"" : '').";
              else " : '' )."
                centrefeature.style.label = data[i].name;
              SiteListLayer.addFeatures([feature, centrefeature]);
              if(typeof onChildFeatureLoad != 'undefined') onChildFeatureLoad(feature, data[i], child_id, childArgs);
            }
        }}
    });
  }
};
";
    $retVal = '<input type="hidden" id="imp-sref-system" name="location:centroid_sref_system" value="2169" >';// TBD value configurable
    if(!$args['allowChangeOfLocation'] && $args['multiSite'] &&
       isset(data_entry_helper::$entity_to_load["sample:updated_by_id"])){ // only set if data loaded from db, not error condition
      // multiple site: parent sample points to parent location in location_id, not parent_id. Each site has own subsample.
      // can not modify parent location, as this will reset all the attached samples and sites, so redering entered data useless. Just delete.
      data_entry_helper::$javascript .= "
loadFeatures(".data_entry_helper::$entity_to_load["sample:location_id"].", '', ".$config['initLoadArgs'].");";
      return $retVal.'
<input type="hidden" name ="sample:location_id" value="'.data_entry_helper::$entity_to_load["sample:location_id"].'" >
<p>'.lang::get('LANG_LocModTool_ParentLabel').' : '.data_entry_helper::$entity_to_load["location:name"].'</p>
<p>'.lang::get("LANG_LocationModuleInstructions2").'</p>
<p>'.lang::get('LANG_NumSites').' : <span id="num-sites"></span></p>
';
    }
    $dummy=array('','');
    if(!$args['multiSite']){
      if(isset(data_entry_helper::$entity_to_load["location:centroid_sref"]))
        $dummy = explode(',',data_entry_helper::$entity_to_load["location:centroid_sref"]);
    }
    $locations = iform_loctools_listlocations($node);
    $locOptions = array('validation' => array('required'),
    					'label'=>lang::get('LANG_LocModTool_ParentLabel'),
    					'id'=>$config['parentFieldID'],
    					'table'=>'location',
    					'fieldname'=>$config['parentFieldName'],
    					'valueField'=>'id',
    					'captionField'=>'name',
    					'template' => 'select',
    					'itemTemplate' => 'select_item',
    					'extraParams'=>array_merge($auth['read'],
    						array('parent_id'=>'NULL',
    								'view'=>'detail',
    								'orderby'=>'name',
    								'location_type_id'=>$args['loctoolsLocTypeID'],
    								'deleted'=>'f')));
    $response = data_entry_helper::get_population_data($locOptions);
    if (isset($response['error'])) return "PARENT LOOKUP ERROR:  ".$response['error'];
    $opts .= str_replace(array('{value}', '{caption}', '{selected}'),
                         array('', htmlentities(lang::get('LANG_LocModTool_ParentBlank')), ''),
                         $indicia_templates[$locOptions['itemTemplate']]);
    foreach ($response as $record) {
      $include=false;
      if($locations == 'all') $include = true;
      else if(in_array($record["id"], $locations)) $include = true;
      if($include == true){
        $caption = htmlspecialchars($record[$locOptions['captionField']]);
        $opts .= str_replace(array('{value}', '{caption}', '{selected}'),
                             array($record[$locOptions['valueField']],
                                   htmlentities($record[$locOptions['captionField']]),
                                   isset(data_entry_helper::$entity_to_load[$config['parentFieldName']]) ? (data_entry_helper::$entity_to_load[$config['parentFieldName']] == $record[$locOptions['valueField']] ? 'selected=selected' : '') : ''),
                             $indicia_templates[$locOptions['itemTemplate']]);
      }
    }
    $locOptions['items'] = $opts;
    $retVal .= '<p>'.lang::get("LANG_LocationModuleInstructions1").'</p>'.
      ($args['multiSite'] ? '<input type="hidden" id="smp-loc-name" name="sample:location_name" value="" >' : "").
      data_entry_helper::apply_template($locOptions['template'], $locOptions).
      '<p>'.lang::get("LANG_LocationModuleInstructions2").'</p>';
    if(!$args['multiSite']){
      // single site, so built site selector drop down.
      $opts = "";
      $locOptions = array('label'=>lang::get('LANG_LocationIDLabel'),
    					'id'=>'sample_location_id',
    					'table'=>'location',
    					'fieldname'=>'sample:location_id',
    					'valueField'=>'id',
    					'captionField'=>'name',
    					'captionExtraField'=>'comment',
    					'template' => 'select',
    					'itemTemplate' => 'select_item',
    					'extraParams'=>array_merge($auth['read'],
    						array('parent_id'=>data_entry_helper::$entity_to_load["location:parent_id"],
    								'view'=>'detail',
    								'orderby'=>'name',
    								'location_type_id'=>$args['LocationTypeID'],
    								'deleted'=>'f')));
      if(isset(data_entry_helper::$entity_to_load["sample:id"])){ // if preloaded, then drop down is dependant on value in parent field: if not then get user to enter parent first
        $response = data_entry_helper::get_population_data($locOptions);
        if (isset($response['error'])) return "CHILD LOOKUP ERROR:  ".$response['error'];
        $opts .= str_replace(array('{value}', '{caption}', '{selected}'),
                         array('', htmlentities(lang::get('LANG_EmptyLocationID')), ''),
                         $indicia_templates[$locOptions['itemTemplate']]);
        foreach ($response as $record) {
          $caption = htmlspecialchars($record[$locOptions['captionField']].($record[$locOptions['captionExtraField']]=="" ? "" : lang::get("LANG_ExtendName").$record[$locOptions['captionExtraField']]));
          $opts .= str_replace(array('{value}', '{caption}', '{selected}'),
                               array($record[$locOptions['valueField']], htmlentities($caption),
                                     isset(data_entry_helper::$entity_to_load['location:id']) ? (data_entry_helper::$entity_to_load['sample:location_id'] == $record[$locOptions['valueField']] ? 'selected=selected' : '') : ''),
                               $indicia_templates[$locOptions['itemTemplate']]);
        }
      } else {
        $opts = "<option >".lang::get("LANG_ChooseParentFirst")."</option>";
      }
      $locOptions['items'] = $opts;
      // single site requires all location data in main form. Mult site must have array: depends on implementation so left to actual form.
      $retVal .= data_entry_helper::apply_template($locOptions['template'], $locOptions)."<br />
<label for='location_name'>".lang::get('LANG_Location_Name_Label').":</label><input type='text' id='location_name' name='location:name' class='required site-name' value='".data_entry_helper::$entity_to_load['location:name']."' /><span class='deh-required'>*</span><br/>
<input type=hidden id=\"imp-sref\" name=\"location:centroid_sref\" value=\"".data_entry_helper::$entity_to_load['location:centroid_sref']."\" />
<input type=hidden id=\"imp-geom\" name=\"location:centroid_geom\" value=\"".data_entry_helper::$entity_to_load['location:centroid_geom']."\" />
<input type=hidden id=\"imp-boundary-geom\" name=\"location:boundary_geom\" value=\"".data_entry_helper::$entity_to_load['location:boundary_geom']."\" />
<input type=hidden id=\"locWebsite\" name=\"locations_website:website_id\" value=\"".$args['website_id']."\" />
<input type=hidden id=\"locComment\" name=\"location:comment\" value=\"".$user->name."\" />
<input type=hidden name=\"location:location_type_id\" value=\"".$args['LocationTypeID']."\" />
<label for=\"imp-srefX\" class=\"auto-width\" >".lang::get('LANG_Location_X_Label').":</label><input type=\"text\" id=\"imp-srefX\" name=\"dummy:srefX\" value=\"".trim($dummy[0])."\" disabled=\"disabled\"/>
<label for=\"imp-srefX\" class=\"auto-width prepad\" >".lang::get('LANG_Location_Y_Label').":</label><input type=\"text\" id=\"imp-srefY\" name=\"dummy:srefY\" value=\"".trim($dummy[1])."\" disabled=\"disabled\"/><span id=\"coords-text\" class=\"coords-text\">".lang::get('LANG_LatLong_Bumpf')."</span><br />
";
      data_entry_helper::$javascript .= "
jQuery(\"#location_parent_id\").change(function(){
  jQuery(\"#imp-geom\").val('');
  jQuery(\"#imp-boundary-geom\").val('');
  jQuery(\"#imp-sref\").val('');
  jQuery(\"#imp-srefX\").val('');
  jQuery(\"#imp-srefY\").val('');
  jQuery(\"#location_name\").val('');
  jQuery(\"#sample_location_id\").val('');
  loadFeatures(this.value, '', {});
});
";
    }
    // the multisite parent location field change function must be defined locally, as it changes too much: still must call loadFeatures.
    return $retVal.($args['multiSite'] ? '<p>'.lang::get('LANG_NumSites').' : <span id="num-sites"></span></p>' : '');;
  }
  
function iform_mnhnl_getAttrID($auth, $args, $table, $caption){
  switch($table){
  	case 'occurrence':
  		$prefix = 'occAttr';
  		break;
  	case 'sample':
  		$prefix = 'smpAttr';
  		break;
  	case 'location':
  		$prefix = 'locAttr';
  		break;
  	default: return false;
  }
  $myAttributes = data_entry_helper::getAttributes(array(
        'valuetable'=>$table.'_attribute_value'
       ,'attrtable'=>$table.'_attribute'
       ,'key'=>$table.'_id'
       ,'fieldprefix'=>$prefix
       ,'extraParams'=>$auth['read']
       ,'survey_id'=>$args['survey_id']
      ), false);
  foreach($myAttributes as $attr)
    if (strcasecmp($attr['untranslatedCaption'],$caption)==0)
      return $attr['attributeId'];

  return false;
}

function iform_mnhnl_getReloadPath(){
  $reload = data_entry_helper::get_reload_link_parts();
  unset($reload['params']['sample_id']);
  unset($reload['params']['occurrence_id']);
  unset($reload['params']['newSample']);
  $reloadPath = $reload['path'];
  if(count($reload['params'])) $reloadPath .= '?'.http_build_query($reload['params']);
  return $reloadPath;
}

function iform_mnhnl_addCancelButton(){
  data_entry_helper::$javascript .= "
jQuery('<div class=\"ui-widget-content ui-state-default ui-corner-all indicia-button tab-cancel\"><span><a href=\"".iform_mnhnl_getReloadPath()."\">".lang::get('LANG_Cancel')."</a></span></div>').appendTo('.buttons');
";
}

function iform_mnhnl_locationButtonsControl($args, $includeLocation, $includeModButtons) {
  data_entry_helper::$javascript .= "
ViewAllCountry = function(lat, long, zoom){
	var div = jQuery('#map')[0];
	var center = new OpenLayers.LonLat(long, lat);
	center.transform(div.map.displayProjection, div.map.projection);
	div.map.setCenter(center, zoom);
};
ZoomToFeature = function(feature){
  var div = jQuery('#map')[0];
  div.map.zoomToExtent(feature.geometry.getBounds());
};
ZoomToSelectedFeature = function(layer){
  if(layer.selectedFeatures.length>0){
    ZoomToFeature(layer.selectedFeatures[0]);
  }
};
ZoomToHightlightedOrSelectedFeature = function(layer){
  if(layer.selectedFeatures.length>0){
    ZoomToFeature(layer.selectedFeatures[0]);
  } else {
    for(var i=0; i<layer.features.length; i++){
      if(layer.features[i].attributes.highlighted == true)
        ZoomToFeature(layer.features[i]);
    }
  }
};
ZoomToDataExtent = function(layer){
  if(layer.features.length > 0) layer.map.zoomToExtent(layer.getDataExtent());
};
CancelSketch = function(layer){
  drawControl.cancel();
};
UndoSketchPoint = function(layer){
  drawControl.undo();
};
";  	
  return '<input type="button" value="'.lang::get('Zoom to Parent').'" onclick="ZoomToDataExtent(ParentLocationLayer);">
'.($includeLocation ? '<input type="button" value="'.lang::get('Zoom to Location').'" onclick="ZoomToHightlightedOrSelectedFeature(SiteListLayer);">' : '' ).'
<input type="button" value="'.lang::get('View All Country').'" onclick="ViewAllCountry('.$args['map_centroid_lat'].','.$args['map_centroid_long'].','.((int) $args['map_zoom']).');">'.
($includeModButtons && $args['usePolygons'] ? '<br /><span>'.lang::get('LANG_ModificationInstructions').'</span><input type="button" value="'.lang::get('Cancel current site').'" onclick="CancelSketch();"><input type="button" value="'.lang::get('Undo site point').'" onclick="UndoSketchPoint();">'.($args['multiSite'] ? '<input type="button" value="'.lang::get('Remove last site').'" onclick="RemoveLastSite();">' : '') : '');
}

