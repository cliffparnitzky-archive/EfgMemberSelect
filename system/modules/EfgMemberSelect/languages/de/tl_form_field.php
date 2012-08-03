<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2011-2012
 * @author     Cliff Parnitzky
 * @package    EfgMemberSelect
 * @license    LGPL
 * @filesource
 */
 
/**
 * Form fields
 */
$GLOBALS['TL_LANG']['FFL']['efgMemberSelect'] = array('Mitglieder Select-Menü', 'Stellt ein Drop-Down-Menü zur Auswahl von Mitgliedern in Formularen zur Verfügung.');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form_field']['memberGroups']                                         = array('Mitgliedergruppen', 'Bitte wählen Sie die Mitgliedergruppe(n) aus. Mitglieder die in mehreren Gruppen vorhanden sind, werden nur einmal aufgelistet.');
$GLOBALS['TL_LANG']['tl_form_field']['includeBlankOption']                                   = array('Leere Option verwenden', 'Bitte wählen Sie ob das Drop-Down-Menü eine leere Option am Anfang enthalten soll.');
$GLOBALS['TL_LANG']['tl_form_field']['blankOptionLabel']                                     = array('Bezeichnung der leeren Option', 'Bitte geben Sie die Bezeichnung der leeren Option ein.');
$GLOBALS['TL_LANG']['tl_form_field']['outputFormat']                                         = array('Ausgabeformat', 'Bitte wählen Sie den Ausgabeformat aus. Dieses wird für die Ausgaben im Frontend sowie, wenn gewählt, für den Rückgabewert <b>Mitglieds-Name</b> verwendet.');
$GLOBALS['TL_LANG']['tl_form_field']['outputFormatOption']['FIRSTNAME_BLANK_LASTNAME']       = 'Vorname Nachname';
$GLOBALS['TL_LANG']['tl_form_field']['outputFormatOption']['LASTNAME_COMMA_BLANK_FIRSTNAME'] = 'Nachname, Vorname';
$GLOBALS['TL_LANG']['tl_form_field']['returnValue']                                          = array('Rückgabewert', 'Bitte wählen Sie den Rückgabewert aus. Dieser wird z.B. für die Email verwendet oder in der Datenbank gespeichert. Das Format für <b>Mitglieds-Name</b> entspricht dem gewählten <i>Ausgabeformat</i>.');
$GLOBALS['TL_LANG']['tl_form_field']['returnValueOption']['ID']                              = 'Mitglieds-ID';
$GLOBALS['TL_LANG']['tl_form_field']['returnValueOption']['NAME']                            = 'Mitglieds-Name';

?>