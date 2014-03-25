<?php

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
 * @copyright  terminal42 gmbh 2013
 * @author     Andreas Schempp <andreas.schempp@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


class InputVar extends Frontend
{

	public function replaceInputVars($strTag)
	{
		$arrTag = explode('::', $strTag);
		$arrOptions = $this->getOptionsFromString($strTag);
		$default = isset($arrOptions['default']) ? $arrOptions['default'] : null;

		if ($arrTag[1] == '')
			return false;

		switch( $arrTag[0] )
		{
			case 'get':
				$this->import('Input');
				$varValue = $this->Input->get($arrTag[1]) ?: $default;
				break;

			case 'post':
				$this->import('Input');
				$varValue = $this->Input->post($arrTag[1]) ?: $default;
				break;

			case 'postHtml':
				$this->import('Input');
				$varValue = $this->Input->postHtml($arrTag[1]) ?: $default;
				break;

			case 'postRaw':
				$this->import('Input');
				$varValue = $this->Input->postRaw($arrTag[1]) ?: $default;
				break;

			case 'cookie':
				$this->import('Input');
				$varValue = $this->Input->cookie($arrTag[1]) ?: $default;
				break;

			case 'session':
				$this->import('Session');
				$varValue = $this->Session->get($arrTag[1]) ?: $default;
				break;

			default:
				return false;
		}

		switch ($arrTag[2])
		{
			case 'mysql_real_escape_string':
			case 'addslashes':
			case 'stripslashes':
			case 'standardize':
			case 'ampersand':
			case 'specialchars':
			case 'nl2br':
			case 'nl2br_pre':
			case 'strtolower':
			case 'utf8_strtolower':
			case 'strtoupper':
			case 'utf8_strtoupper':
			case 'ucfirst':
			case 'lcfirst':
			case 'ucwords':
			case 'trim':
			case 'rtrim':
			case 'ltrim':
			case 'utf8_romanize':
			case 'strlen':
			case 'strrev':
				$varValue = $arrTag[2]($varValue);
				break;

			case 'decodeEntities':
			case 'encodeEmail':
				$this->import('String');
				$varValue = $this->String->{$arrTag[2]}($varValue);
				break;

			case 'number_format':
				$varValue = number_format($varValue, 0, $GLOBALS['TL_LANG']['MSC']['decimalSeparator'], $GLOBALS['TL_LANG']['MSC']['thousandsSeparator']);
				break;

			case 'number_format_2':
				$varValue = number_format($varValue, 2, $GLOBALS['TL_LANG']['MSC']['decimalSeparator'], $GLOBALS['TL_LANG']['MSC']['thousandsSeparator']);
				break;
		}

		return is_array($varValue) ? implode(', ', $varValue) : $varValue;
	}

	/**
	 * Get options from Inserttag
	 *
	 * @todo This should most likely be implemented in the core
	 *       https://github.com/contao/core/blob/master/system/modules/core/library/Contao/Controller.php#L1490
	 *
	 * @param  string $strInsertTag The inserttag
	 * @return array                An array of options
	 */
	public function getOptionsFromString($strInsertTag)
	{
		$strOptions = explode('?', $strInsertTag);
		$arrOptions = explode('&', $strOptions[1]);
		$arrOptionsResult = array();

		foreach($arrOptions as $strOption)
		{
			$arrOption = explode('=', $strOption);
			$arrOptionsResult[$arrOption[0]] = isset($arrOption[1]) ? $arrOption[1] : true;
		}

		return $arrOptionsResult;
	}
}
