<?php

/**
 * Avisota newsletter and mailing system
 * Copyright © 2016 Sven Baumann
 *
 * PHP version 5
 *
 * @copyright  way.vision 2016
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @package    avisota/contao-subscription-notification-center-bridge
 * @license    LGPL-3.0+
 * @filesource
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_nc_notification']['avisotaFilterByMailingList'] = array('Send to specific mailing lists only', 'Send this notification only if a specific mailing list is subscribed or unsubscribed.');
$GLOBALS['TL_LANG']['tl_nc_notification']['avisotaFilteredMailingLists'] = array('Mailing lists', 'Please choose the mailing lists this notification should send for.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_nc_notification']['avisota_legend'] = 'Avisota';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_nc_notification']['type']['avisota-subscription']         = 'Avisota Subscription';
$GLOBALS['TL_LANG']['tl_nc_notification']['type']['avisota_subscribe']            = 'Subscribe';
$GLOBALS['TL_LANG']['tl_nc_notification']['type']['avisota_confirm_subscription'] = 'Confirm subscription';
$GLOBALS['TL_LANG']['tl_nc_notification']['type']['avisota_unsubscribe']          = 'Unsubscribe';
