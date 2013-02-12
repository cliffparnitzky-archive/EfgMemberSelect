<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2011-2013
 * @author     Cliff Parnitzky
 * @package    EfgMemberSelect
 * @license    LGPL
 * @filesource
 */
 
/**
 * Add a palette to tl_form_field
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'efgMemberSelectIncludeBlankOption';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['efgMemberSelect'] = '{type_legend},type,name,label;{options_legend},efgMemberSelectMembers,efgMemberSelectMemberGroups,efgMemberSelectIncludeBlankOption,efgMemberSelectOutputFormat,efgMemberSelectReturnValue,efgMemberSelectRemoveLoggedMember,efgMemberSelectShowInactiveMembers;{fconfig_legend},mandatory,multiple;{expert_legend:hide},class,accesskey;{submit_legend},addSubmit';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['efgMemberHidden'] = '{type_legend},type,name;{options_legend},efgMemberSelectMembers,efgMemberSelectMemberGroups,efgMemberSelectRemoveLoggedMember,efgMemberSelectShowInactiveMembers;{submit_legend},addSubmit';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['efgMemberSelectIncludeBlankOption'] = 'efgMemberSelectBlankOptionLabel';

/**
 * Add fields to tl_form_field
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectMembers'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectMembers'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'foreignKey' => 'tl_member.CONCAT(firstname," ",lastname)',
	'eval'       => array('mandatory'=>false, 'multiple'=>true)
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectMemberGroups'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectMemberGroups'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'foreignKey' => 'tl_member_group.name',
	'eval'       => array('mandatory'=>false, 'multiple'=>true)
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectIncludeBlankOption'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectIncludeBlankOption'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'eval'       => array('tl_class'=>'w50 m12 clr', 'submitOnChange'=>'true')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectBlankOptionLabel'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectBlankOptionLabel'],
	'exclude'    => true,
	'inputType'  => 'text',
	'eval'       => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectOutputFormat'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectOutputFormat'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => array(
												FormMemberSelectMenu::OUTPUT_FORMAT_FIRSTNAME_BLANK_LASTNAME => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectOutputFormatOption'][FormMemberSelectMenu::OUTPUT_FORMAT_FIRSTNAME_BLANK_LASTNAME],
												FormMemberSelectMenu::OUTPUT_FORMAT_LASTNAME_COMMA_BLANK_FIRSTNAME => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectOutputFormatOption'][FormMemberSelectMenu::OUTPUT_FORMAT_LASTNAME_COMMA_BLANK_FIRSTNAME]
							 				),
	'eval'      => array('multiple'=>false, 'tl_class'=>'w50 clr')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectReturnValue'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectReturnValue'],
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => array(
												FormMemberSelectMenu::RETURN_VALUE_ID => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectReturnValueOption'][FormMemberSelectMenu::RETURN_VALUE_ID],
												FormMemberSelectMenu::RETURN_VALUE_NAME => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectReturnValueOption'][FormMemberSelectMenu::RETURN_VALUE_NAME]
											),
	'eval'      => array('multiple'=>false, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectRemoveLoggedMember'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectRemoveLoggedMember'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'eval'       => array('tl_class'=>'w50 clr m12')
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['efgMemberSelectShowInactiveMembers'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['efgMemberSelectShowInactiveMembers'],
	'exclude'    => true,
	'inputType'  => 'checkbox',
	'eval'       => array('tl_class'=>'w50 m12')
);

?>