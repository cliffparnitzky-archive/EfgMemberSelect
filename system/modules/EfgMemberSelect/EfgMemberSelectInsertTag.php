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
 * Class EfgMemberSelectInsertTag
 *
 * InsertTag hook class.
 * @copyright  Cliff Parnitzky 2013
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class EfgMemberSelectInsertTag extends Controller
{
	public function __construct() {
		parent::__construct();
		$this->import('Database');
		$this->import('Input');
	}
	
	/**
	 * Replaces the special insert tags.
	 */
	public function replaceEfgMemberSelectInsertTags($strTag) {
		$strTag = explode('::', $strTag);
		if ($strTag[0] == 'formmember' && strlen($strTag[1]) > 0 && strlen($strTag[2]) > 0) {
		
			$formFieldName = $strTag[1];
			$attributeIndex = 2;

			$ids = array();
			// at first we check $_POST, for parameter
			$formParam = $this->Input->post($formFieldName);
			if (is_null($formParam)) {
				// nothing was found in $_POST, maybe we find something in $_GET
				$formParam = $this->Input->get($formFieldName);
			}
			
			if (!is_null($formParam)) {
				if (is_array($formParam)) {
					foreach ($formParam as $id) {
						if (is_numeric($id)) {
							$ids[] = $id;
						}
					}
				} else {
					if (is_numeric($formParam)) {
							$ids[] = $formParam;
					}
				}
			}
			
			$returnString = "";

			if (count($ids) > 0) {
				$objMember = $this->Database->prepare("SELECT * FROM tl_member WHERE id in (" . implode(",", $ids) . ")")
																		->execute();
				while($objMember->next()) {
					if (strlen($returnString) > 0) {
						// adding a separator
						$returnString .= ", ";
					}
					$returnString .= $this->getValue($objMember, $strTag, $attributeIndex);
				}
			}
			return $returnString;
		}
		return false;
	}
	
	/**
	 * Returns the value for the member attribute
	 */
	private function getValue($member, $strTag, $attributeIndex) {
		$value = $member->$strTag[$attributeIndex];

		$this->loadDataContainer('tl_member');

		if ($GLOBALS['TL_DCA']['tl_member']['fields'][$strTag[$attributeIndex]]['inputType'] == 'password')
		{
			// do not allow extracting the password
			return "";
		}

		$value = deserialize($value);
		$rgxp = $GLOBALS['TL_DCA']['tl_member']['fields'][$strTag[$attributeIndex]]['eval']['rgxp'];
		$opts = $GLOBALS['TL_DCA']['tl_member']['fields'][$strTag[$attributeIndex]]['options'];
		$rfrc = $GLOBALS['TL_DCA']['tl_member']['fields'][$strTag[$attributeIndex]]['reference'];
		$fkey = $GLOBALS['TL_DCA']['tl_member']['fields'][$strTag[$attributeIndex]]['foreignKey'];

		$returnValue = '';
		if ($rgxp == 'date' || $rgxp == 'time' || $rgxp == 'datim')
		{
			$dateFormat = $GLOBALS['TL_CONFIG'][$rgxp . 'Format'];
			// check if custom format was set
			if (count($strTag) == $attributeIndex + 2 && strlen($strTag[$attributeIndex + 1]) > 0) {
				$dateFormat = $strTag[$attributeIndex + 1];
			}
			$returnValue = $this->parseDate($dateFormat, $value);
		}
		elseif (is_array($value))
		{
			$returnValue = implode(', ', $value);
			if (strlen($fkey) > 0)
			{
				$returnValue = $this->getArrayValueAsList($fkey, $returnValue);
			}
		}
		elseif (is_array($opts) && array_is_assoc($opts))
		{
			$returnValue = isset($opts[$value]) ? $opts[$value] : $value;
		}
		elseif (is_array($rfrc))
		{
			$returnValue = isset($rfrc[$value]) ? ((is_array($rfrc[$value])) ? $rfrc[$value][0] : $rfrc[$value]) : $value;
		}
		elseif ($strTag[$attributeIndex] == 'age')
		{
			$returnValue = floor((date("Ymd") - date("Ymd", $member->dateOfBirth)) / 10000);
		}
		elseif ($strTag[$attributeIndex] == 'name')
		{
			$returnValue = $member->firstname . " " . $member->lastname;
		}
		elseif ($strTag[$attributeIndex] == 'salutation')
		{
			$returnValue = $GLOBALS['TL_LANG']['MSC']['salutation_' . $member->gender];
			if (strlen($returnValue) == 0)
			{
				return "";
			}
		}
		elseif ($strTag[$attributeIndex] == 'welcoming')
		{
			$key = $strTag[$attributeIndex] . '_formally';
			if (count($strTag) == $attributeIndex + 2 && strlen($strTag[$attributeIndex + 1]) > 0 && $strTag[$attributeIndex + 1] == 'personally') {
				$key = $strTag[$attributeIndex] . '_personally';
			}
			$returnValue = $GLOBALS['TL_LANG']['MSC'][$key . '_' . $member->gender];
			if (strlen($returnValue) == 0)
			{
				$returnValue = $GLOBALS['TL_LANG']['MSC'][$key];
			}
		}
		else
		{
			$returnValue = $value;
		}

		// Convert special characters (see #1890)
		return specialchars($returnValue);	
	}
	
		
	/**
	 * get all values of the given array
	 */
	private function getArrayValueAsList($foreignKey, $valueIds)
	{
		$foreignKey = explode('.', $foreignKey);
		$table = $foreignKey[0];
		$fieldname = $foreignKey[1];
		if (strlen($table) > 0 && strlen($valueIds) > 0)
		{
			$values = $this->Database->prepare("SELECT " . $fieldname . " FROM " . $table . " WHERE id IN (" . $valueIds . ") ORDER BY name ASC")
								->execute();
			$list = array();
			while ($values->next())
			{
				$list[] = $values->$fieldname;
			}
			return implode(", ", $list);
		}
		return "";
	}
}
?>