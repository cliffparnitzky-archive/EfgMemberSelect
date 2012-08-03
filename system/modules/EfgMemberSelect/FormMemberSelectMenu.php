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

class FormMemberSelectMenu extends FormSelectMenu
{
	/**
	 * Overwritten, to set widget template for BE List
	 */
	public function parse($arrAttributes=false)
	{
		if(TL_MODE == 'BE' && $this->memberGroups == null)
		{
			$this->strTemplate = 'be_widget';
		}
		return parent::parse($arrAttributes); 
	}
	
	/**
	 * Overwritten, to set class attribute
	 */
	public function generateWithError($blnSwitchOrder=false)
	{
		if(TL_MODE == 'BE' && $this->memberGroups == null)
		{
			$this->strClass .= (strlen($this->strClass) ? ' ' . $this->strClass : '') . 'tl_select';
		}
		return parent::generateWithError($blnSwitchOrder); 
	}
	
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		// first check if required extension 'associategroups' is installed
		if (!in_array('associategroups', $this->Config->getActiveModules()))
		{
			$this->log('EfgMemberSelect: Extension "associategroups" is required!', 'FormMemberSelectMenu generate()', TL_ERROR);
			return false;
		}

		$this->import('Database');
		
		if(TL_MODE == 'BE' && $this->memberGroups == null)
		{
			$config = $this->Database->prepare("SELECT memberGroups, includeBlankOption, blankOptionLabel, outputFormat, returnValue "
																	."FROM tl_form_field "
																	."WHERE id = (SELECT ff_id FROM tl_formdata_details WHERE pid = ? AND ff_type = ? AND ff_name = ?)")
																->execute($this->currentRecord, $this->type, $this->name);
																
			$this->memberGroups = $config->memberGroups;
			$this->includeBlankOption = $config->includeBlankOption;
			$this->blankOptionLabel = $config->blankOptionLabel;
			$this->outputFormat = $config->outputFormat;
			$this->returnValue = $config->returnValue;
		}

		$groups = deserialize($this->memberGroups);
		if (is_array($groups))
		{
			$groups = join(',',$groups);
		}
		if (strlen($groups) == 0)
		{
			$groups = '-1';
		}

		$orderBy = 'tl_member.firstname, tl_member.lastname';

		if ($this->outputFormat == 'LASTNAME_COMMA_BLANK_FIRSTNAME')
		{
			$orderBy = 'tl_member.lastname, tl_member.firstname';
		}

		$members = $this->Database->prepare("SELECT DISTINCT tl_member.* "
											."FROM tl_member, tl_member_to_group "
											."WHERE tl_member_to_group.member_id = tl_member.id AND tl_member_to_group.group_id IN ($groups) "
											."ORDER BY $orderBy")
										->execute();
										
		if ($this->includeBlankOption)
		{
			$this->arrOptions[] = array
			(
				'value' => "",
				'label' => specialchars($this->blankOptionLabel),
			);
		}

		while ($members->next())
		{
			// Add member if active
			if ($this->isMemberActive($members))
			{
				$value = $members->id;
				$label = $members->firstname . " " . $members->lastname;

				if ($this->outputFormat == 'LASTNAME_COMMA_BLANK_FIRSTNAME')
				{
					$label = $members->lastname . ", " . $members->firstname;
				}

				if ($this->returnValue == 'NAME')
				{
					$value = $label;
				}

				$this->arrOptions[] = array
				(
					'value' => $value,
					'label' => $label,
				);
			}
		}
		
		if (TL_MODE == 'FE')
		{
			$this->varValue = deserialize($this->varValue);
		}

		return parent::generate();
	}

	/**
	 * Checks if the member is active.
	 * @return boolean
	 */
	private function isMemberActive($member)
	{
		if ($member->disable ||
			(strlen($member->start) > 0 && $member->start > time()) ||
			(strlen($member->stop) > 0 && $member->stop < time()))
		{
			return false;
		}
		return true;
	}
}

?>