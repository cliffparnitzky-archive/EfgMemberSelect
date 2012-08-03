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
$GLOBALS['TL_LANG']['FFL']['efgMemberSelect'] = array('Member Select-Menu', 'Provides a Drop-Down-Menu for selecting members in a form.');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form_field']['memberGroups']                                         = array('Membergroups', 'Please select the membergroup(s). Members that are in several groups, will be listed only once.');
$GLOBALS['TL_LANG']['tl_form_field']['includeBlankOption']                                   = array('Blank option', 'Please select if a blank option must be added to the options array of hte drop-down menu.');
$GLOBALS['TL_LANG']['tl_form_field']['blankOptionLabel']                                     = array('Blank option label', 'Please select a label for the blank option.');
$GLOBALS['TL_LANG']['tl_form_field']['outputFormat']                                         = array('Outputformat', 'Please select the output format. This will be used in frontend and, if selected, for the return value <b>Member-Name</b>.');
$GLOBALS['TL_LANG']['tl_form_field']['outputFormatOption']['FIRSTNAME_BLANK_LASTNAME']       = 'Firstname Lastname';
$GLOBALS['TL_LANG']['tl_form_field']['outputFormatOption']['LASTNAME_COMMA_BLANK_FIRSTNAME'] = 'Lastname, Firstname';
$GLOBALS['TL_LANG']['tl_form_field']['returnValue']                                          = array('Return value', 'Please select the value to be returned. This will be used e.g. in emails or for storing in the database. The format for <b>Member-Name</b> matches the selected <i>Outputformat</i>.');
$GLOBALS['TL_LANG']['tl_form_field']['returnValueOption']['ID']                              = 'Member-ID';
$GLOBALS['TL_LANG']['tl_form_field']['returnValueOption']['NAME']                            = 'Member-Name';

?>