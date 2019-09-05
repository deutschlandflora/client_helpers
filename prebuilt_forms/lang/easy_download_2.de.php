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

global $custom_terms;

/**
 * Language terms for the easy_download_2 form.
 *
 * @package	Client
 */
$custom_terms = array(
  'format_csv'=>'Komma-separierte Tabelle (CSV)',
  'format_tsv'=>'Tab-separierte Tabelle (TSV)',
  'format_recorder'=>'Komma-separierte Tabelle (Recorder-Struktur)',
  'format_kml'=>'Google Earth (KML)',
  'format_gpx'=>'GPS track (GPX)',
  'format_nbn'=>'NBN Exchange',
  'Select the type of download you require, i.e. the purpose for the data. This defines which records are available to download.' => 'Wählen Sie den Nutzungszweck aus, damit die Daten entsprechend gefiltert werden',
  'Optionally select from the available filters. Filters you create on the Explore pages will be available here.' => 'Wählen Sie optional einen Filter aus. Filter, die Sie zuvor unter Berichte/Beobachtungen erstellt haben, sind hier verfügbar',
  'Leave blank for no start date filter' => 'Geben Sie ein Startdatum im Format JJJJ-MM-TT an oder lassen Sie das Feld frei (ohne Datumsfilter)',
  'Leave blank for no end date filter' =>'Geben Sie ein Enddatum im Format JJJJ-MM-TT an oder lassen Sie das Feld frei (ohne Datumsfilter)',
  'Start Date' => 'Startdatum',
  'End Date' => 'Enddatum',
  'If filtering on date, which date field would you like to filter on?' => 'Wenn Sie nach Datum filtern, worauf soll sich das Datum beziehen?',
  'Limit the records' => 'Anzahl der Daten begrenzen',
  'Records to download' => 'Daten für den Download',
  'Download type' => 'Art des Downloads',
  'Filter to apply' => 'Filter',
  'Select a format to download' => 'Wählen Sie das Format für den Download',
  'My records for reporting' => 'Meine Berichtsdaten',
  'All records for reporting' => 'Alle Berichtsdaten',
  'Peer Review' => 'Daten zur Begutachtung durch Experten',
  'Peer review' => 'Daten zur Begutachtung durch Experten',
  'Verification - my verification records' => 'Meine Daten zur Verifizierung',
  'Verification status change date' => 'Änderung am Verifizierungsstatus',
  'All records for {1}' => 'Alle Daten zu Gruppe {1}',
  'My records contributed to {1}' => 'Meine Daten zu Gruppe {1}',
  'All records added using a recording form for {1}' => 'Alle Daten zur {1}',
  'My records added using a recording form for {1}' => 'Meine Daten zur {1}',
  'Data flow' => 'Daten zur Weitergabe',
  'Data Flow' => 'Daten zur Weitergabe',
  'Survey to include' => 'Projekt einbeziehen',
  'Choose a survey, or <all> to not filter by survey.' => 'Wählen Sie das Projekt oder <Alle> für den Download'
  
  
);