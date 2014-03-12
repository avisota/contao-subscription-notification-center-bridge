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

namespace Avisota\Contao\SubscriptionNotificationCenterBridge;

use Avisota\Contao\Subscription\Event\SubscribeEvent;
use Avisota\Contao\Subscription\SubscriptionEvents;
use Avisota\Recipient\RecipientInterface;
use NotificationCenter\Model\Notification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Bridge
 */
class SubscriptionNotificationCenterBridgeEvents
{
	/**
	 * The BUILD_TOKENS_FROM_RECIPIENT event occurs when a recipient must converted into tokens,
	 * when create a notification.
	 *
	 * The event listener method receives
	 * a Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromRecipientEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const BUILD_TOKENS_FROM_RECIPIENT = 'avisota.subscription-notification-center-bridge.build-tokens-from-recipient';
}
