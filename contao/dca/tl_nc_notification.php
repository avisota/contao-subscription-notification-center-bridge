<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-core
 * @license    LGPL-3.0+
 * @filesource
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
