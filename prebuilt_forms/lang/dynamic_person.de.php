﻿<?php
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
 * Additional language terms or overrides for dynamic_person form.
 *
 * @package	Client
 */
$custom_terms = array_merge($custom_terms, array(
  'LANG_First_Name' => 'Vorname',
  'LANG_Surname' => 'Nachname',
  'LANG_Last_Name' => 'Nachname',
  'LANG_Email_Address' => 'E-Mail Addresse',
  )
);