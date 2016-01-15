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
 * Event subscribers
 */
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Avisota\Contao\SubscriptionNotificationCenterBridge\Bridge';

/**
 * Notifications
 */
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['avisota-subscription'] = array
(
    'avisota_subscribe'            => array
    (
        'recipients'           => array
        (
            'recipient_email',
        ),
        'email_sender_name'    => array
        (
            'recipient_*',
        ),
        'email_sender_address' => array
        (
            'recipient_email',
        ),
        'email_recipient_cc'   => array
        (
            'recipient_email',
        ),
        'email_recipient_bcc'  => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
        ),
        'email_subject'        => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
        ),
        'email_text'           => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
            'subscription_*',
            'mailing_list_*',
        ),
        'email_html'           => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
            'subscription_*',
            'mailing_list_*',
        ),
    ),
    'avisota_confirm_subscription' => array
    (
        'recipients'           => array
        (
            'recipient_email',
        ),
        'email_sender_name'    => array
        (
            'recipient_*',
        ),
        'email_sender_address' => array
        (
            'recipient_email',
        ),
        'email_recipient_cc'   => array
        (
            'recipient_email',
        ),
        'email_recipient_bcc'  => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
        ),
        'email_subject'        => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
        ),
        'email_text'           => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
            'subscription_*',
            'mailing_list_*',
        ),
        'email_html'           => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
            'subscription_*',
            'mailing_list_*',
        ),
    ),
    'avisota_unsubscribe'          => array
    (
        'recipients'           => array
        (
            'recipient_email',
        ),
        'email_sender_name'    => array
        (
            'recipient_*',
        ),
        'email_sender_address' => array
        (
            'recipient_email',
        ),
        'email_recipient_cc'   => array
        (
            'recipient_email',
        ),
        'email_recipient_bcc'  => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
        ),
        'email_subject'        => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
        ),
        'email_text'           => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
            'subscription_*',
            'mailing_list_*',
        ),
        'email_html'           => array
        (
            'datetime',
            'date',
            'time',
            'recipient_id',
            'recipient_email',
            'recipient_*',
            'subscription_*',
            'mailing_list_*',
        ),
    ),
);
