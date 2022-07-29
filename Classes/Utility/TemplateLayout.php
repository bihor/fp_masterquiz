<?php
/***************************************************************
 *  Copyright notice
*
*  (c) 2014 Frans Saris <franssaris@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/*
 * modified 2019 by Kurt Gusbeth
*/
namespace Fixpunkt\FpMasterquiz\Utility;

/**
 * TemplateLayout: Template-Layout per TSconfig
 *
 * @package fp_masterquiz
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TemplateLayout implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Get available template layouts for a page
	 *
	 * @param int $pageUid
	 * @return array
	 */
	public function getAvailableTemplateLayouts($pageUid)
	{
		$templateLayouts = array();
		foreach($this->getTemplateLayoutsFromTsConfig($pageUid) as $templateKey => $title) {
			$templateLayouts[] = array($title, $templateKey);
		}
		return $templateLayouts;
	}

	/**
	 * Get template layouts defined in TSconfig
	 *
	 * @param $pageUid
	 * @return array
	 */
	protected function getTemplateLayoutsFromTsConfig($pageUid)
	{
		$templateLayouts = array();
		$pagesTsConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($pageUid);
		if (isset($pagesTsConfig['tx_fpmasterquiz.']['templateLayouts.']) && is_array($pagesTsConfig['tx_fpmasterquiz.']['templateLayouts.'])) {
			$templateLayouts = $pagesTsConfig['tx_fpmasterquiz.']['templateLayouts.'];
		}
		return $templateLayouts;
	}
}
