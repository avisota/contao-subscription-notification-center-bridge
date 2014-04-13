<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 *
 * @copyright  terminal42 gmbh 2013
 * @license    LGPL
 */

/**
 * Table tl_nc_notification
 */
$GLOBALS['TL_DCA']['tl_nc_notification']['metapalettes']['avisota_subscribe']             = array(
	'title'   => array('title', 'type'),
	'avisota' => array('avisotaFilterByMailingList'),
);
$GLOBALS['TL_DCA']['tl_nc_notification']['metasubpalettes']['avisotaFilterByMailingList'] = array(
	'avisotaFilteredMailingLists',
);

$GLOBALS['TL_DCA']['tl_nc_notification']['fields']['avisotaFilterByMailingList'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_nc_notification']['avisotaFilterByMailingList'],
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval'      => array(
		'submitOnChange' => true,
	),
	'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_nc_notification']['fields']['avisotaFilteredMailingLists'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_nc_notification']['avisotaFilteredMailingLists'],
	'exclude'          => true,
	'inputType'        => 'checkbox',
	'options_callback' => array('Avisota\Contao\Core\DataContainer\OptionsBuilder', 'getMailingListOptions'),
	'eval'             => array(
		'mandatory' => true,
		'multiple'  => true,
	),
	'sql'              => "text NULL"
);
