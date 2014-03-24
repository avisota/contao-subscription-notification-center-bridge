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

use Avisota\Contao\Entity\Subscription;
use Avisota\Contao\Subscription\Event\ConfirmSubscriptionEvent;
use Avisota\Contao\Subscription\Event\ResolveRecipientEvent;
use Avisota\Contao\Subscription\Event\SubscribeEvent;
use Avisota\Contao\Subscription\Event\UnsubscribeEvent;
use Avisota\Contao\Subscription\SubscriptionEvents;
use Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromRecipientEvent;
use Avisota\Recipient\RecipientInterface;
use NotificationCenter\Model\Notification;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Bridge
 */
class Bridge implements EventSubscriberInterface
{
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			SubscriptionEvents::SUBSCRIBE            => 'subscribe',
			SubscriptionEvents::CONFIRM_SUBSCRIPTION => 'confirm',
			SubscriptionEvents::UNSUBSCRIBE          => 'unsubscribe',
		);
	}

	public function subscribe(SubscribeEvent $event)
	{
		$tokens = $this->buildTokens($event->getSubscription());
		$this->sendNotification('avisota_subscribe', $tokens);
	}

	public function confirm(ConfirmSubscriptionEvent $event)
	{
		$tokens = $this->buildTokens($event->getSubscription());
		$this->sendNotification('avisota_confirm_subscription', $tokens);
	}

	public function unsubscribe(UnsubscribeEvent $event)
	{
		$tokens = $this->buildTokens($event->getSubscription());
		$this->sendNotification('avisota_unsubscribe', $tokens);
	}

	/**
	 * @param Subscription $subscription
	 *
	 * @return \ArrayObject
	 */
	protected function buildTokens(Subscription $subscription)
	{
		/** @var EventDispatcher $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$event = new ResolveRecipientEvent($subscription);
		$eventDispatcher->dispatch(SubscriptionEvents::RESOLVE_RECIPIENT, $event);

		$recipient = $event->getRecipient();

		$event = new BuildTokensFromRecipientEvent($recipient);
		$eventDispatcher->dispatch(SubscriptionNotificationCenterBridgeEvents::BUILD_TOKENS_FROM_RECIPIENT, $event);

		return $event->getTokens();
	}

	/**
	 * @param string       $type
	 * @param \ArrayObject $tokens
	 */
	protected function sendNotification($type, \ArrayObject $tokens)
	{
		$notificationCollection = Notification::findBy('type', $type);
		if (null !== $notificationCollection) {
			while ($notificationCollection->next()) {
				$notification = $notificationCollection->current();
				/** @var Notification $notification */
				$notification->send($tokens->getArrayCopy());
			}
		}
	}
}
