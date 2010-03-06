<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */


class InputVar extends Frontend
{

	public function replaceInputVars($strTag)
	{
		$this->import('Input');
		$this->import('Session');
		
		$arrTag = explode('::', $strTag);
		
		if (!is_array($arrTag) || !strlen($arrTag[1]) || !strlen($arrTag[1]))
			return false;
		
		switch( $arrTag[0] )
		{
			case 'get':
				return $this->Input->get($arrTag[1]);
			
			case 'post':
				return $this->Input->post($arrTag[1]);
				
			case 'postHtml':
				return $this->Input->postHtml($arrTag[1]);
				
			case 'postRaw':
				return $this->Input->postRaw($arrTag[1]);
				
			case 'cookie':
				return $this->Input->cookie($arrTag[1]);
				
			case 'session':
				return $this->Session->get($arrTag[1]);
		}
		
		return false;
	}
}

