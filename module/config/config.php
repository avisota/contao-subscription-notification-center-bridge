<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota/contao-subscription-notification-center-bridge
 * @license    LGPL-3.0+
 * @filesource
 */


/**
 * Event subscribers
 */
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Avisota\Contao\SubscriptionNotificationCenterBridge\Bridge';


/**
 * Notifications
 */
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['avisota-subscription'] = array
(
	'avisota_subscribe' => array
	(
		'recipients' => array
		(
			'recipient_email',
		),
		'email_sender_name' => array
		(
			'recipient_name',
		),
		'email_sender_address' => array
		(
			'recipient_email',
		),
		'email_recipient_cc' => array
		(
			'recipient_email',
		),
		'email_recipient_bcc' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_subject' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_text' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_html' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
	),
	'avisota_confirm_subscription' => array
	(
		'recipients' => array
		(
			'recipient_email',
		),
		'email_sender_name' => array
		(
			'recipient_name',
		),
		'email_sender_address' => array
		(
			'recipient_email',
		),
		'email_recipient_cc' => array
		(
			'recipient_email',
		),
		'email_recipient_bcc' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_subject' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_text' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_html' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
	),
	'avisota_unsubscribe' => array
	(
		'recipients' => array
		(
			'recipient_email',
		),
		'email_sender_name' => array
		(
			'recipient_name',
		),
		'email_sender_address' => array
		(
			'recipient_email',
		),
		'email_recipient_cc' => array
		(
			'recipient_email',
		),
		'email_recipient_bcc' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_subject' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_text' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
		'email_html' => array
		(
			'datetime',
			'recipient_type',
			'recipient_id',
			'recipient_name',
			'recipient_email',
		),
	),
);
