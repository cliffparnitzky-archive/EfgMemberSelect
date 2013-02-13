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

class FormMemberHiddenField extends FormHidden {

	public function __construct($arrAttributes=false) {
		parent::__construct($arrAttributes);
		$this->import('Database');
		$this->import('FrontendUser', 'User');
		
		// first check if necessary extension 'associategroups' is installed
		if (!in_array('associategroups', $this->Config->getActiveModules())) {
			$this->log('EfgMemberSelect: Extension [associategroups] is necessary!', 'FormMemberSelectMenu generate()', TL_ERROR);
			$this->addError('Extension [associategroups] is necessary!');
		} else if ($this->efgMemberSelectMembers != null || $this->efgMemberSelectMemberGroups != null) {
			$this->generate();
		}
	}
	
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate () {
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

		$members = $this->Database->prepare("SELECT DISTINCT tl_member.* "
											."FROM tl_member, tl_member_to_group "
											."WHERE tl_member.id IN ($memberIds) OR (tl_member_to_group.member_id = tl_member.id AND tl_member_to_group.group_id IN ($groupIds)) "
											."ORDER BY tl_member.firstname, tl_member.lastname")
										->execute();
										
		$hiddenFields = "";
		$backendOutput = array();

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
				$hiddenFields .= sprintf('<input type="hidden" name="%s[]" value="%s" />', $this->strName, specialchars($members->id));
				$backendOutput[] = $members->firstname . " " . $members->lastname;
			}
		}
		if(TL_MODE == 'BE') {
			$this->varValue = "<ul><li>" . implode("</li><li>", $backendOutput) . "</li></ul>";
		}
		return $hiddenFields;
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