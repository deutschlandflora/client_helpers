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
 
global $default_terms;

/**
 * Provides a list of default localisable terms used by the lang class.
 *
 * @package	Client
 */
$default_terms = array( 
  //Import
  'Import data into the {1} group' => 'Import in Kartiergruppe {1}',
  'Upload' => 'Hochladen',
  'Instructions for Import Step 1' => 'Der folgende Dialog führt Sie durch den Import von Beobachtungsdaten. '.
                    'Um Probleme zu vermeiden beachten Sie bitte, dass Ihre Datei im CSV-Format (Komma-getrennt) vorliegen muss und als UTF-8 abgespeichert wurde. '.
                    'Das Format kann mit gängigen Programmen zur Tabellenkalkulation, z.B. Excel, Calc von LibreOffice oder OpenOffice erstellt werden. '.
                    'Öffnen Sie dazu die gewünschte Tabelle mit Beobachtungsdaten und exportieren diese über Speichern unter und wählen als Dateityp CSV. Wählen Sie als Zeichensatz UTF-8 und als Feldtrenner das Komma. '.
                    'Der Spaltenkopf muss die exakte Bezeichnung des Attributs enthalten. '.
                    'Sie können sich über den nachfolgenden Link eine Vorlage herunterladen und die Spalten übernehmen. '.
                    'Mit * gekennzeichnete Spalten sind obligatorisch. Optionale Spalten können auch leere Zellen enthalten. Empfohlen wird auch die Verwendung der aktuellen taxonomischen Referenz zum Abgleich der Artnamen. '.
                    'Weitere Infos zur Strukur und den verfügbaren Attributen entnehmen Sie bitte der Hilfe-Seite  <a href="../hilfe-zur-eingabe" target="_blank">Hilfe-Seite</a>',
  'Select *.csv (comma separated values) file to upload' => 'Vorhandene .csv-Datei auswählen',
  'Select the survey to import records into.' => 'Wählen Sie das Projekt, in das die Daten importiert werden sollen',
  'Select the spatial reference system used in this import file. Note, if you have a file with a mix of spatial reference systems then you need a column in the import file which is mapped to the Sample Spatial Reference System field containing the spatial reference system code.' => 'Wählen Sie das Raumbezugssystem ihrer Daten. Wenn Sie verschiedene Systeme in Ihrer Datei verwendet haben, muss es eine Spalte mit den EPSG-Codes in Ihrer Datei geben.',
  'Select the species checklist which will be used when attempting to match species names.' => 'Geben Sie die taxonomische Referenz an, zu der Sie Daten importieren wollen. Während des Importvorgangs werden die Daten mit der Artenliste abgeglichen.',
   'Select the sample method used for records in this import file. Note, if you have a file with a mix of sample methods then you need a ' .
        'column in the import file which is mapped to the Sample Sample Method field, containing the sample method.' => 'Wählen Sie die Aufnahmemethode für Daten in diesem Import. Haben Sie einen Mix unterschiedlicher Methoden in Ihrer Aufnahme verwendet, benötigen Sie eine Spalte in Ihrer Datei, die die jeweilige Methode angibt.',
  'Defined in file' => 'In Dateispalte angegeben',
  'Species list' => 'Taxonomische Referenz',
  'Spatial ref. system' => 'Raumbezugssystem',
  'Select the initial status for imported records' => 'Geben Sie den initialen Bearbeitungsstatus für Ihre zu importierenden Daten an',
  'Data entry complete/unverified' => 'Dateneingabe abgeschlossen, unverifiziert',
  'Verified' => 'Verifiziert',
  'Data entry still in progress' => 'Dateneingabe nicht abgeschlossen',
  'Import Settings' => 'Import Einstellungen',
  'import_settings_instructions' => 'Bevor sie mit dem Import fortfahren, prüfen Sie bitte folgende Einstellungen. Diese gelten für alle Datensätze der Importdatei. '.
      'Einstellungen, die sie hier nicht vornehmen, können sie über die Importdatei mittels Mapping der Spalten im nächsten Schritt machen.'.
      ' Der Bearbeitungsstatus sollte auf Eingabe abgeschlossen gesetzt werden, wenn Sie zu dieser Aufnahme (ein Kartierereignis an einem Ort) voraussichtlich keine weiteren Beobachtungen hinzufügen möchten.',      
  'Used in lookup of existing data?' => 'Mapping-Lookup?',
  'Grid Ref and Date' => 'Koordinaten und Datum',
  'Sample records' => 'Aufnahmen',
  'Occurrence records' => 'Art-Beobachtungen',
  'Sample External Key' => 'Externe ID der Aufnahme',
  'Sample ID' => 'Aufnahme-ID',
  'Location Record and Date' => 'Fundort, Datensatz und Datum',
  'Sample and Taxon' => 'Aufnahme-ID und Taxon',
  'Occurrence External Key' => 'Externe ID des Datensatzes',
  'Occurrence ID' => 'Datensatz-ID',
   'Lookup of existing records' => 'Aktualisierung von Datensätzen - Kriterien zum Abgleich mit vorhandenen Daten',
  'Do not look up existing records' => 'Vorhandene Daten nicht berücksichtigen',
  'Because you are looking up existing records to import into, required field validation will only be applied when the new data are merged into the existing data during import.' => 'Da Sie Importdaten mit vorhandenen Daten abgleichen wird eine Validierung der Datenbank-Felder nur angewendet, wenn Ihre neuen Daten mit den vorhandenen Daten vereint werden. Ihre vorhandenen Daten werden dabei aktualisiert.',
  'Note that updating of existing records is only available when the Prevent Commits On Any Error importer option is not being used' => 'Das Aktualisieren vorhandener Daten funktioniert nur, wenn Fehlermeldungen beim Import ignoriert werden',
  'column_mapping_instructions' => 'Bitte ordnen Sie jede Spalte Ihrer CSV-Importdatei dem entsprechenden Attribut der Datenbank zu. Das System hat '.
      'versucht, die Spalten zu den vorhandenen Attributen zuzuordnen. Prüfen Sie bitte die Zuordnung, bevor Sie mit dem Importvorgang fortfahren. '.
      ' Wenn Sie die Spaltenüberschrften der Vorlagendatei verwendet haben, brauchen Sie normalerweise nichts zu tun, da das System die Spalten erkennt. '.
      'Wenn Sie in Zukunft weitere Importe mit gleicher Struktur vonehmen möchten, markieren Sie bitte die Checkbox (entfällt, wenn Sie die Vorlagendatei verwenden). ' .
      'Wenn Sie Spalten importieren, die Werte aus referenzierten Tabellen enthalten (z.B. Floristischer Status), müssen die Werte mit den hinterlegten Referenzwerten übereinstimmen.',
  'upload_not_available' => 'Die hochgeladene Datei ist nicht mehr temporär vorhanden. Bitte laden Sie die Datei nochmals hoch.',
  'Could not upload file. Please check that the indicia_svc_import module is enabled on the Warehouse.' => 'Upload nicht möglich. Prüfen Sie ob das svc_import-Modul aktiviert ist oder fragen Sie ihren Administrator.',
  'Column in CSV File' => 'Spalte der CSV-Datei',
  'Maps to attribute' => 'Attribut in Datenbank zuordnen',
  'Remember choice?' => 'Auswahl merken?',
  'Tick all boxes to remember every column mapping next time you import.' => 'Markieren Sie die Spalten, die Sie für den nächsten Import als Vorauswahl speichern möchten.',
  'There are currently two or more drop-downs allocated to the same value.' => 'Zwei oder mehr Attribute sind dem gleichen Spalten-Wert zugeordnet.',
  'The following database attributes must be matched to a column in your import file before you can continue' => ' Folgende Datenbankattribute müssen einer Spalte ihrer Datei zugeordnet werden, bevor Sie fortfahren können.',
  'Tasks' => 'Vorgehensweise',
   '{1} problems were detected during the import.' => '{1} Probleme traten beim Upload auf.',
  'download_error_file_instructions' => 'Download der Fehlerdatei:',
  'Download the records that did not import.' => 'Laden Sie zum Überprüfen der Daten folgende csv-Datei herunter und korrigieren Sie fehlerhafte Datensätze anhand der Hinweise in der angehängten Spalte.',
  'The upload was successful.' => 'Die Daten wurden erfolgreich importiert und im System gespeichert. Wenn Sie möchten, können Sie nun eine weitere Datei importieren. ',
   'Would you like to ' => 'Möchten Sie ',
  'import another file?' => 'eine weitere Datei importieren?',
  'Could not upload file. Please check that the indicia_svc_import module is enabled on the Warehouse.' => 'Upload nicht möglich. Prüfen Sie ob das svc_import-Modul aktiviert ist oder fragen Sie ihren Administrator.',
  'Not imported' => 'Nicht importiert',
  '<Not imported>' => '<Nicht importiert>',
  'lookup existing record' => 'Referenzierte Werte',
  'Preparing to upload.' => 'Zum Import vorbereiten',
  "Could not upload the settings metadata. <br/>" => "Konnte die Einstellungen zu Metadaten nicht uploaden",
  'Please check the suggested mapping above is correct.' => 'Bitte prüfen Sie, ob die Zuordnung der Spalte korrekt ist.',
  'Uploaded file must be a csv file' =>  'Die Datei muss die Formatendung .csv besitzen. Bitte speichern Sie Ihre Datei als Komma-getrennte (csv) Datei ab.',
  //Optionslist
  'updated_on' => 'aktualisiert am',
  'created_on' => 'erstellt am',
  'deleted' => 'gelöscht',
  "This form is configured so that it must be called with a type parameter in the URL" => "Diese Seite ist so konfiguriert, dass sie mit dem Typ-Parameter in der URL aufgerufen werden muss",
  'Would you like to ' => 'Möchten Sie ',
  'import another file?' => 'eine weitere Datei importieren?',
  'Website' => 'Webseite',
  'Survey' => 'Projekt',
  'Sample Method' => 'Aufnahmemethode',
  'Next' => 'Weiter',
  'Record Status' => 'Bearbeitungsstatus',
  'Record status' => 'Bearbeitungsstatus',
  'Select the initial status for imported species records' => 'Wählen Sie den initialen Bearbeitungsstatus für Ihre zu importierenden Daten',
  'occurrence:record_status' => 'Bearbeitungsstatus',
  'Verified' => 'Verifizierte Daten',
  'Data entry still in progress' => 'Datenimport offen',
  'Data entry complete/unverified' => 'Datenimport geschlossen/unverifiziert',
  'C:Data entry complete/unverified,V:Verified,I:Data entry still in progress' => 'C:Datenimport geschlossen/unverifiziert,V:Verifizierte Daten,I:Datenimport offen',
  'please select' => 'Bitte wählen',
  'created_by_id' => 'Erstellt durch',
  'dd:SmpAttr' => 'Benutzerdefinierte Felder zu Aufnahmen',
  'dd:Occurrence' => 'Beobachtung',
  'dd:sample' => 'Aufnahme',
  'dd:sample:fk_parent' => 'Übergeordnete Aufnahme (Referenzierte Werte)',
  'dd:sample:fk_parent:external_key' => 'Externe ID der übergeordneten Aufnahme (Referenzierte Werte)',
  'dd:sample:fk_sample_method' => 'Aufnahmemethode (Referenzierte Werte)',
  'dd:sample:fk_survey' => 'Projekt (Referenzierte Werte)',
  'dd:sample:date_type' => 'Datumstyp (Referenzierte Werte)',
  'dd:sample:date' => 'Aufnahmedatum (TT.MM.JJJJ)*',
  'dd:sample:date:day' => 'Aufnahmetag (TT)',
  'dd:sample:date:month' => 'Aufnahmemonat (MM)',
  'dd:sample:date:year' => 'Aufnahmejahr (JJJJ)',
  'dd:sample:date_end' => 'Startdatum (TT.MM.JJJJ)',
  'dd:sample:date_start' => 'Enddatum (TT.MM.JJJJ)',
  'dd:sample:created_on' => 'Aufnahme erstellt am (TT.MM.JJJJ)',
  'dd:sample:verified_on' => 'Aufnahme bestätigt am (TT.MM.JJJJ)',
  'dd:sample:updated_on' => 'Aufnahme aktualisiert am (TT.MM.JJJJ)',
  'dd:sample:external_key' => 'Externe ID der Aufnahme',
  'dd:sample:entered_sref' => 'Koordinaten (Breite, Länge)',
  'dd:sample:entered_sref_system' => 'Koordinatensystem (EPSG-Code)',
  'dd:sample:comment' => 'Kommentar zur Aufnahme',
  'dd:sample:location_name' => 'Fundortbezeichnung',
  'dd:smpAttr:33' => 'verantwortlicher Beobachter*',
  'dd:smpAttr:34' => 'Fundortbeschreibung',
  'dd:smpAttr:29' => 'Standort/Wuchsort',
  'dd:sample:fk_location' => 'Fundort (Ortsreferenz)',
  'dd:sample:fk_location:code' => 'Fundorttyp (Referenzierte Werte)',
  'dd:sample:fk_location:external_key' => 'Externe ID des Fundortes (Referenzierte Werte)',
  'dd:smpAttr:12' => 'Höhe von oder von-bis (m)',
  'dd:sample:recorder_names' => 'Mitbeobachter',
  'dd:sample:fk_created_by' => 'Aufnahme erstellt durch (Referenzierte Werte)',
  'dd:sample:fk_updated_by' => 'Aufnahme aktualisiert durch (Referenzierte Werte)',
  'dd:sample:fk_verified_by' => 'Aufnahme bestätigt durch (Referenzierte Werte)',
  'dd:smpAttr:35' => 'Aufnahmedauer (h.m)',
  'dd:sample:fk_group' => 'Kartiergruppe (Referenzierte Werte)',
  'dd:sample:record_status' => 'Bearbeitungsstatus der Aufnahme',
  'dd:sample:fk_licence' => 'Lizenztyp (Referenzierte Werte)',
  'dd:sample:privacy_precision' => 'Darstellungsgenauigkeit (m) bei vertraulichen Daten',
  'dd:sample:input_form' => 'Eingabeform',
  'dd:occurrence:all_info_in_determinations' => 'nicht verwendet',
  'dd:occurrence:fk_taxa_taxon_list:search_code' => 'nicht verwendet',
  'dd:occurrence:record_decision_source' => 'nicht verwendet',
  'dd:occurrence:comment' => 'Kommentar zur Art-Beobachtung',
  'dd:occurrence:external_key' => 'Externe ID der Beobachtung',
  'dd:occurrence:fk_taxa_taxon_list' => 'Taxname (BfN-Referenz)*',
  'dd:occurrence:fk_taxa_taxon_list:external_key' => 'Taxnummer (BfN-Referenz)',
  'dd:occAttr:fk_4' =>'Floristischer Status (Referenzierte Werte)*',
  'dd:occurrence:fk_created_by' => 'Datensatz erstellt durch (Referenzierte Werte)',
  'dd:occurrence:fk_updated_by' => 'Datensatz aktualisiert durch (Referenzierte Werte)',
  'dd:occurrence:fk_verified_by' => 'Beobachtung bestätigt durch (Referenzierte Werte)',
  'dd:occurrence:fk_determiner' => 'Bestimmer (Referenzierte Werte)',
  'dd:occAttr:8'	=> 'Name des Bestimmers',	
  'dd:occAttr:fk_9' => 'Bestimmungssicherheit (sicher/unsicher)',
  'dd:occurrence:zero_abundance' => 'Nullnachweis? (Ja/Nein)' ,
  'dd:occurrence:confidential' => 'Beobachtung vertraulich?',
  'dd:occurrence:created_on' => 'Beobachtung erstellt am (TT.MM.JJJJ)',
  'dd:occurrence:updated_on' => 'Beobachtung aktualisiert am (TT.MM.JJJJ)',
  'dd:occurrence:verified_on' => 'Beobachtung bestätigt am (TT.MM.JJJJ)',
  'dd:occAttr:1' => 'Datum der Bestimmung (TT.MM.JJJJ)',
  'dd:occurrence:last_verification_check_date' => 'Datum der letzten Prüfung (TT.MM.JJJJ)',
  'dd:occAttr:7' => 'Belegnummer',	
  'dd:occAttr:fk_11' => 'Belegtyp (Referenzierte Werte)',
  'dd:occAttr:6' => 'Herbarium',
  'dd:occAttr:17' => 'Häufigkeit (Textangabe)',
  'dd:occAttr:fk_15' => 'Natürlichkeitsgrad (Referenzierte Werte)',
  'dd:occurrence:record_status' => 'Bearbeitungsstatus der Beobachtung',
  'dd:occurrence:training' => 'Testeingabe? (Ja/Nein)',
  'dd:occurrence:record_substatus' => 'Substatus der Beobachtung',
  'dd:occurrence:release_status' => 'Status der Veröffentlichung',
  'dd:occurrence:sensitivity_precision' => 'Darstellungsgenauigkeit (m) bei Sensiblen Daten',
  'dd:occurrence_media:caption:1' => 'Bildtitel 1',
  'dd:occurrence_media:caption:2' => 'Bildtitel 2',
  'dd:occurrence_media:caption:3' => 'Bildtitel 3',
  'dd:occurrence_media:caption:4' => 'Bildtitel 4',
  'dd:occurrence_media:path:1' => 'Pfad zu Bild 1',
  'dd:occurrence_media:path:2' => 'Pfad zu Bild 2',
  'dd:occurrence_media:path:3' => 'Pfad zu Bild 3',
  'dd:occurrence_media:path:4' => 'Pfad zu Bild 4',
  'dd:occurrence:deleted' => 'Datensatz gelöscht?',
  'dd:occurrence:downloaded_flag' => 'Datensatz heruntergeladen? (nicht verwendet)',
  'dd:occurrence:downloaded_on' => 'Datensatz heruntergeladen am (nicht verwendet)',
  'dd:smpAttr:37' => 'Gemeinschaftskartierung? (Ja/Nein)',
   'sref:4326'=>'WGS84 (decimal Breite,Länge)'
   
   
  
);