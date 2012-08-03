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
 * Add a palette to tl_form_field
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'includeBlankOption';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['efgMemberSelect'] = '{type_legend},type,name,label;{options_legend},memberGroups,includeBlankOption,outputFormat,returnValue;{fconfig_legend},mandatory,multiple;{expert_legend:hide},class,accesskey;{submit_legend},addSubmit';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['includeBlankOption'] = 'blankOptionLabel';

/**
 * Add fields to tl_form_field
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['memberGroups'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['memberGroups'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'foreignKey' => 'tl_member_group.name',
	'eval'       => array('mandatory'=>true, 'multiple'=>true)
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['includeBlankOption'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['includeBlankOption'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'eval'       => array('tl_class'=>'w50', 'submitOnChange'=>'true')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['blankOptionLabel'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['blankOptionLabel'],
	'exclude'    => true,
	'inputType'  => 'text',
	'eval'       => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['outputFormat'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['outputFormat'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => array(
												'FIRSTNAME_BLANK_LASTNAME' => &$GLOBALS['TL_LANG']['tl_form_field']['outputFormatOption']['FIRSTNAME_BLANK_LASTNAME'],
												'LASTNAME_COMMA_BLANK_FIRSTNAME' => &$GLOBALS['TL_LANG']['tl_form_field']['outputFormatOption']['LASTNAME_COMMA_BLANK_FIRSTNAME']
							 				),
	'eval'      => array('multiple'=>false, 'tl_class'=>'w50 clr')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['returnValue'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['returnValue'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => array(
												'ID' => &$GLOBALS['TL_LANG']['tl_form_field']['returnValueOption']['ID'],
												'NAME' => &$GLOBALS['TL_LANG']['tl_form_field']['returnValueOption']['NAME']
											),
	'eval'      => array('multiple'=>false, 'tl_class'=>'w50')
);

?>