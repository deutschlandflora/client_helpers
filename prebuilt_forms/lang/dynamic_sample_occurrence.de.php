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
 * @author	Indicia Team
 * @license	http://www.gnu.org/licenses/gpl.html GPL 3.0
 * @link 	http://code.google.com/p/indicia/
 */

include_once 'dynamic.de.php';

/**
 * Additional language terms or overrides for dynamic_sample_occurrence form.
 *
 * @package	Client
 */
$custom_terms = array_merge($custom_terms, array(
	//Grid mode
	'next'=>'nächste',
  'prev'=>'vorherige',
  'previous'=> 'vorherige',
  'Showing records {1} to {2} of {3}' => 'Zeige Datensätze {1} bis {2} von {3}',
  'first' => 'erste',
  'last' => 'letzte',
  'Sort by' => 'Sortieren nach ',
	
	'LANG_Add_Sample' => 'Neue Aufnahme',
  'LANG_Add_Sample_Single' => 'Einzelne Beobachtung',
  'LANG_Add_Sample_Grid' => 'Liste von Beobachtungen',

	'LANG_Tab_aboutyou' => 'Über Sie',      
	'LANG_Tab_Instructions_aboutyou' => '<strong>Über sie</strong><br/>Angaben zu Ihrer Person.',
	// Can also add entries each of the attribute captions used in this tab.
	// Note these do not have LANG_ prefixes.
  
  //Tab What
	'LANG_Tab_species' => 'Was kartiert?',
	'Please enter the species you saw and any other information about them.' =>'Wählen Sie die Arten, die sie kartiert haben, danach können Sie mit dem nächsten Schritt fortfahren.',
	'LANG_Tab_Instructions_species' => '<strong>Artauswahl</strong><br/>Klicken Sie die Arten an, die sie kartiert haben, danach können Sie mit dem nächsten Schritt fortfahren.',
	// The species and presence column titles in the grid may be set by adding entries for 'species_checklist.species'
	// and 'species_checklist.present'. All the others are not translated, but taken directly from the attribute caption.
	'species_checklist.species' => 'Artname',
	'species_checklist.present' => 'Beobachtet',
	'species_checklist.sensitivity' => 'Sensitiv',
	'LANG_Sample_Comment_Label' => 'Weitere Infos',
	'LANG_Species' => 'Art',
	'Blur' => 'Unschärfe einstellen',
	'Comment' => 'Kommentar zur Beobachtung',
	'LANG_Ad_Media' => 'Medien',
  //Tab Where
	'LANG_Tab_place' => 'Wo kartiert?',
	'LANG_Tab_Instructions_place' => '<strong>Wo kartiert?</strong><br/>Bitte geben Sie einen Ort und Raumbezug der Beobachtung oder klicken Sie auf die Karte, um den Ort festzulegen.',
	'Please provide the spatial reference of the record. You can enter the reference directly, ' .
				'or search for a place then click on the map to set it.' => 'Bitte geben Sie eine Fundortbezeichnung und den Raumbezug der Beobachtung an oder klicken Sie auf die Karte, um den Ort festzulegen.',
	'LANG_SRef_Label' => 'Koordinaten und Bezugssystem',
	'sref:4326'=>'WGS84 (decimal lat,long)',
	'sref:31466'=>'DHDN / Gauss-Kruger zone 2(x,y)',
  'sref:31467'=>'DHDN / Gauss-Kruger zone 3(x,y)',
  'sref:31468'=>'DHDN / Gauss-Kruger zone 4(x,y)',
  'sref:25832'=>'ETRS89 / UTM zone 32N',
  'sref:25833'=>'ETRS89 / UTM zone 33N',
  'sref:25834'=>'ETRS89 / UTM zone 34N',
  'sref:4044'=>'ETRS89 / UTM zone 32N (N-E)',
  'sref:4745'=>'Messtischblattquadrant',
  'sref:3857' => 'Web Mercator',
  'sref_900913' => '(Google) Spherical Mercator',
	'LANG_Location_Label' => 'gespeicherte (Fund-)Orte',
	'LANG_Location_Name' => 'Fundort Name',
	'LANG_Georef_Label' => 'Suche nach Ortsnamen',
	'search' => 'Suche',
	'Search' => 'Suche',
	
	//species map
	"Add records to map" => "Fundpunkt in Karte setzen",
	"Please click on the map where you would like to add your records. Zoom the map in for greater precision." => "Bitte klicken Sie in die Karte, um neue Fundorte zu ergänzen oder klicken Sie auf einen vorhandenen Punkt, um weitere Beobachtungen einzugeben.",
	"Please enter all the species records for this position into the grid below. When you have finished, click the Finish button to return to the map where you may choose another grid reference to enter data for." => "Bitte geben Sie alle Beobachtungen für diesen Fundort in die Tabelle unten ein.",
	"Move records" => "Funde verschieben",
	"Please select the records on the map you wish to move." => "Bitte klicken Sie auf die Beobachtung, die Sie verschieben möchten.",
	"Please click on the map to choose the new position. Press the Cancel button to choose another set of records to move instead." => "Bitte klicken Sie auf die Karte, um eine neue Position zu wählen.",
	"Modify records" => "Datensätze bearbeiten",
	"Please select the records on the map you wish to change." => "Bitte klicken Sie auf die Beobachtung und wählen die Datensätze, die Sie ändern möchten.",
	"Change (or add to) the records for this position. When you have finished, click the Finish button which will return you to the map where you may choose another set of records to change." => "ändern Sie den Datensatz oder fügen Sie einen neuen hinzu. Wenn Sie fertig sind klicken Sie den Button Dateneingabe beenden.",
	"Delete records" => " Daten löschen",
	"Please select the records on the map you wish to delete." => "Bitte klicken Sie auf die Beobachtung und wählen den Datensatz, den Sie löschen möchten.",
	"Confirm deletion of records" => "Bestätigen Sie das Löschen der Daten",
	"Are you sure you wish to delete all the records at {OLD}?" => "Sind Sie sicher, dass Sie alle Daten bei {OLD} löschen möchten?",
	"Cancel" => "Abbrechen",
	"Finish" => "Dateneingabe beenden",
	"Yes" => "Ja",
	"No" => "Nein",
	'Boundary of {1} for the {2} group' => 'Kartiergebiet für Gruppe {2}',
	'Recording area for the {1} group' => 'Kartiergebiet für Gruppe {1}',
	
	//Tab Other Information
  'LANG_Tab_Other' => 'sonstige Angaben',
  'LANG_Other_Information_Tab' => 'Sonstige Angaben',
  'Other Information' => 'sonstige Angaben',
  'Please provide the following additional information.' => 'Bitte geben sie noch ergänzende Angaben zur Beobachtung an.',
  
  'Recorder names' => 'Namen der Kartierer',
  'LANG_Recorder names_Label' => 'Namen der Kartierer',
  'LANG_Record_Status_Label' => 'Bearbeitungsstatus:',
	'LANG_Record_Status_I' => 'Vorläufig',
	'LANG_Record_Status_C' => 'Abgeschlossen',
	'LANG_Record_Status_T' => 'Testdaten',
	'LANG_Record_Status_V' => 'Verifiziert', // NB not used
	'LANG_Record_Status_helpText' => 'Soll die Dateneingabe für die weitere Bearbeitung offen bleiben oder abgeschlossen werden? Nach Abschluss der Dateneingabe kann eine Prüfroutine und erste Verifizierung erfolgen.',
	'LANG_Date' => 'Datum der Aufnahme',
	'LANG_Date_click_here' => 'Datum wählen...',
	'LANG_Image_Label' => 'Bild Hochladen',
  'LANG_Comment' => 'Kommentar zur Beobachtung',
  'LANG_Overall_Comment_Label' => 'Kommentar zur Aufnahme',
  'Overall_Comment' => 'Kommentar',
  'Overall Comment' => 'Kommentar zur Aufnahme', 
  'Record Comment' => 'Kommentar zur Beobachtung',
	'LANG_Save' => 'Speichern',
  'LANG_Blank_Text' => 'Auswählen...',
	'validation_required' => 'Bitte einen Wert für dieses Feld angeben',
	'LANG_Edit' => 'Bearbeiten',
	'Edit' => 'Bearbeiten',
	'Overall Photo' => 'Bild zur Aufnahme',
	'Overall comment' => 'Kommentar zur Aufnahme',
	'Add photo' => 'Foto hochladen',
	'Add photos' => 'Foto hochladen',
  'Upload your photos' => 'Foto hochladen',
  'Photos' => 'Foto zur Art',
  'photo' => 'Foto', 
  'file' => 'Datei',
  'link' => 'Link',
  'Media' => 'Mediendatei',
  'New {1}' => 'Neue(s) {1}',
  'Add {1}' => '{1} hochladen',
  'Use the Add file button to select a file from your local disk. Files of type {1} are allowed.' => 'Verwenden Sie den Hinzufügen-Button, um eine Datei hochzuladen. Dateien vom Typ {1} sind erlaubt.',
  'Delete' => 'Löschen',
  'select a species first' => 'Zuerst Art wählen',
  'Select a species first' => 'Zuerst Art wählen',
  'add media' => 'Medien',
  'add images' => 'Bild hinzufügen',
  'Add media' => 'Medien',
  'Add images' => 'Bild hinzufügen',
  'Files' => 'Dateien',
  'Close the search results' => 'Suchergebnis schlie&szlig;en',
	'Sensitivity' => 'Empfindlichkeit',
  'Not sensitive' => 'nicht sensibel',
  'Blur record to' => 'Unscharf maskieren',
  'Blur to 100m' => '100m',
  'Blur to 1km' => '1km',
  'Blur to 2km' => '2km',
  'Blur to 10km' => '10km',
  'Blur to 100km' => '100km',
  'none' => 'Punktgenau darstellen',
  'This is the precision that the record will be shown at for public viewing' => 'Sensible Daten werden punktscharf gespeichert, bei der Ausgabe aber mit der angegebenen Unschärfe angezeigt.',
  'Is the record sensitive?' => 'Sensible Daten?',
  'Site name' => 'Fundort',
  '# Occurrences' => 'Anzahl',  //der Beobachtungen, Datensätze
  'Date' => 'Datum',
  'Actions' => 'Aktion',
  'No information available' => 'Keine Daten',
	'This records you enter using this form will be added to the <strong>{1}</strong> group.' => 'Die eingegebenen Daten werden zur Kartiergruppe <strong>{1}</strong> abgelegt.',
	'The records on this form are part of the <strong>{1}</strong> group.' => 'Die Daten dieser Aufnahme sind Teil von <strong>{1}</strong> group.',
	'Choose whether to post your records into {1}.' => 'Sofern Sie Mitglied einer Kartiergruppe sind, wählen Sie bitte wo Sie ihre Daten ablegen möchten {1} !',
 	'The records on this form are licenced as <strong>{1}</strong>.' => 'Die Daten dieser Aufnahme stehen unter der Lizenz von <strong>{1}</strong>.',
 	'This records you enter using this form will be licenced as <strong>{1}</strong>.' => 'Alle Daten, die Sie hier eingeben, werden unter der Lizenz von <strong>{1}</strong> gehalten.',
	'Post to {1}' => 'Daten unter {1} abspeichern?',
	'Precheck my records' => 'Dateneingabe prüfen',
	'Submit' => 'Speichern',
	'Before continuing, some of the values in the input ' .
    'boxes on this page need checking. They have been highlighted on the form for you.' => 'Bevor Sie fortfahren, prüfen Sie bitte die markierten Felder auf Vollständigkeit.',
  'unlocked tool-tip' => 'Klicken Sie hier, um den aktuellen Wert zu zwischenzuspeichern und bei weiteren Eingaben wieder zu verwenden.',
  'locked tool-tip' => 'Klicken Sie hier, um den gepseicherten Kontrollwert zu bearbeiten oder aufzuheben.',
  'submit ok but file failed'=>'Ihre Bilddatei wurde übermittelt, aber beim Speichern trat ein Fehler auf:',
  'Before checking, please complete at least the date and grid reference of the record.' => 'Geben Sie bitte zumindest Datum und Koordinaten oder Raster ein, bevor sie fortfahren.',

  'LANG_No_User_Id' => 'Diese Form ist so konfiguriert, dass eine Tabelle mit existierenden Daten vorangestellt wird.'.
                       'Sie können entweder mittels Button neue Aufnahme neue Daten eingeben oder mittels Link Edit einen vorhandenen Datensatz bearbeiten.'.
                       ' Die Anzeige der Tabelle erfordert eine CMS User ID, gegen die die Daten gefiltert werden.'.
                       'Falls Sie keine Tabelle anzeigen möchten, machen Sie ein Häckchen bei Skip initial Grid.',
					   
   'Add an association' => 'Wirts-Beziehung hinzufügen',
   'The list of species has been loaded into the form for you. ' .
   'Please fill in the other form values before saving the form.' =>  'Die Artenliste wurde in das Formular geladen. Bitte füllen Sie weitere Felder aus, bevor Sie das Formular speichern.',
   'The records you enter using this form will be licenced as <strong>{1}</strong>.' => 'Daten, die sie über dieses Formular eingeben, werden unter folgender Lizenz gespeichert <strong>{1}</strong>.',
   'Attempt to access a record you did not create' => 'Sie haben keine Berechtigung dazu, einen Datensatz aufzurufen, den Sie nicht selbst erstellt haben.'

)
);