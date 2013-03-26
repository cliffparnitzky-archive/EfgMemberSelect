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

class FormMemberSelectMenu extends FormSelectMenu {

	const OUTPUT_FORMAT_FIRSTNAME_BLANK_LASTNAME = 'FORMAT_FIRSTNAME_BLANK_LASTNAME';
	const OUTPUT_FORMAT_LASTNAME_COMMA_BLANK_FIRSTNAME = 'LASTNAME_COMMA_BLANK_FIRSTNAME';
	
	const RETURN_VALUE_ID = 'ID';
	const RETURN_VALUE_NAME = 'NAME';
	
	public function __construct($arrAttributes=false) {
		parent::__construct($arrAttributes);
		$this->import('Database');
		$this->import('FrontendUser', 'User');
		
		// first check if necessary extension 'associategroups' is installed
		if (!in_array('associategroups', $this->Config->getActiveModules())) {
			$this->log('EfgMemberSelect: Extension [associategroups] is necessary!', 'FormMemberSelectMenu generate()', TL_ERROR);
			$this->addError('Extension [associategroups] is necessary!');
		} else if ($this->efgMemberSelectMembers != null || $this->efgMemberSelectMemberGroups != null) {
			$this->setMemberOptions();
		}
	}
	
	/**
	 * Setting the options array
	 */
	private function setMemberOptions () {
		$memberIds = deserialize($this->efgMemberSelectMembers);
		if (is_array($memberIds)) {
			$memberIds = join(',',$memberIds);
		}
		if (strlen($memberIds) == 0) {
			$memberIds = '-1';
		}
		
		$groupIds = deserialize($this->efgMemberSelectMemberGroups);
		if (is_array($groupIds)) {
			$groupIds = join(',',$groupIds);
		}
		if (strlen($groupIds) == 0) {
			$groupIds = '-1';
		}

		$orderBy = 'tl_member.firstname, tl_member.lastname';

		if ($this->efgMemberSelectOutputFormat == FormMemberSelectMenu::OUTPUT_FORMAT_LASTNAME_COMMA_BLANK_FIRSTNAME) {
			$orderBy = 'tl_member.lastname, tl_member.firstname';
		}

		$members = $this->Database->prepare("SELECT DISTINCT tl_member.* "
											."FROM tl_member, tl_member_to_group "
											."WHERE tl_member.id IN ($memberIds) OR (tl_member_to_group.member_id = tl_member.id AND tl_member_to_group.group_id IN ($groupIds)) "
											."ORDER BY $orderBy")
										->execute();
										
		if ($this->efgMemberSelectIncludeBlankOption) {
			$this->arrOptions[] = array
			(
				'value' => "",
				'label' => specialchars($this->efgMemberSelectBlankOptionLabel),
			);
		}

		while ($members->next()) {
			$addMember = true;
			
			if ($this->efgMemberSelectRemoveLoggedMember && $this->User->id == $members->id) {
				$addMember = false;
			}
			
			if (!$this->efgMemberSelectShowInactiveMembers && !$this->isMemberActive($members)) {
				$addMember = false;
			}
			
			// Add member
			if ($addMember) {
				$value = $members->id;
				$label = $members->firstname . " " . $members->lastname;

				if ($this->efgMemberSelectOutputFormat == FormMemberSelectMenu::OUTPUT_FORMAT_LASTNAME_COMMA_BLANK_FIRSTNAME)
				{
					$label = $members->lastname . ", " . $members->firstname;
				}

				if ($this->efgMemberSelectReturnValue == FormMemberSelectMenu::RETURN_VALUE_NAME)
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
	}
	
	/**
	 * Overwritten, to set widget template for BE List
	 */
	public function parse($arrAttributes=false) {
		if(TL_MODE == 'BE' && ($this->efgMemberSelectMembers == null || $this->efgMemberSelectMemberGroups)) {
			$this->strTemplate = 'be_widget';
		}
		return parent::parse($arrAttributes); 
	}
	
	/**
	 * Overwritten, to set class attribute
	 */
	public function generateWithError($blnSwitchOrder=false) {
		if(TL_MODE == 'BE' && ($this->efgMemberSelectMembers == null || $this->efgMemberSelectMemberGroups)) {
			$this->strClass .= (strlen($this->strClass) ? ' ' . $this->strClass : '') . 'tl_select';
		}
		return parent::generateWithError($blnSwitchOrder); 
	}
	
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate() {
		if(TL_MODE == 'BE' && ($this->efgMemberSelectMembers == null || $this->efgMemberSelectMemberGroups)) {
			// there is no config, e.g. in [efg]
			$fieldId = $GLOBALS['TL_DCA']['tl_formdata']['fields'][$this->name]['ff_id'];
			if ($fieldId > 0)
			{
				$config = $this->Database->prepare("SELECT * FROM tl_form_field WHERE id = ?")->execute($fieldId);
				
				$this->efgMemberSelectMembers = $config->efgMemberSelectMembers;
				$this->efgMemberSelectMemberGroups = $config->efgMemberSelectMemberGroups;
				$this->efgMemberSelectIncludeBlankOption = $config->efgMemberSelectIncludeBlankOption;
				$this->efgMemberSelectBlankOptionLabel = $config->efgMemberSelectBlankOptionLabel;
				$this->efgMemberSelectOutputFormat = $config->efgMemberSelectOutputFormat;
				$this->efgMemberSelectReturnValue = $config->efgMemberSelectReturnValue;
				$this->efgMemberSelectRemoveLoggedMember = $config->efgMemberSelectRemoveLoggedMember;
				$this->efgMemberSelectShowInactiveMembers = $config->efgMemberSelectShowInactiveMembers;
				
				$this->setMemberOptions();
			}
		}
		
		if (TL_MODE == 'FE') {
			$this->varValue = deserialize($this->varValue);
		}
		return parent::generate();
	}

	/**
	 * Checks if the member is active.
	 * @return boolean
	 */
	private function isMemberActive($member) {
		if ($member->disable ||
			(strlen($member->start) > 0 && $member->start > time()) ||
			(strlen($member->stop) > 0 && $member->stop < time())) {
			return false;
		}
		return true;
	}
}

?>