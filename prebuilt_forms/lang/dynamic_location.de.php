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
 * Additional language terms or overrides for dynamic locations form.
 *
 * @package	Client
 */
$custom_terms = array_merge($custom_terms, array(
  'LANG_Location_Name' => 'Neue Fundortbezeichnung angeben',
  'LANG_Location_Code' => 'Orts-Code',
  'LANG_Location_Type' => 'Orts-Typ',
  'LANG_Tab_Location' => 'Fundort?',
  'LANG_Add_Location' => 'Neuen Ort hinzufügen',
  'LANG_No_User_Id' => 'Mit diesem Formular kann der Anwender eine Tabelle mit bestehenden Orten anzeigen, neue Orte erstellen oder vorhandene bearbeiten. ' .
    'Das Formular erfordert eine Funktion hostsite_get_user_field exists und liefert eine Indicia-User-ID' .
    'In Drupal ist dies mit dem Easy Login Modul in Verbindung mit dem iForm Modul möglich. '.
    'Alternativ können Sie "Skip initial grid of data" unter "User Interface" im Edit-Modus des Formulars anklicken.',
   'Please provide the spatial reference of the location. You can enter the reference directly, or search for a place then click on the map to set it.' => 'Geben Sie bitte den Raumbezug für den Ort an. Sie ' . 'können die Koordinaten entweder direkt angeben oder nach einem Ort suchen und dann die genaue Position per Klick in der Karte festlegen.',
   'Please provide the following additional information.' => 'Hier können Sie ergänzende Angaben machen.',
   'File upload' => 'Datei hochladen',
   'Add photo' => 'Foto hinzufügen',
   'Add {1}' => 'Foto hinzufügen',
   'New {1}' => 'Neue(s) {1}'
  )
);