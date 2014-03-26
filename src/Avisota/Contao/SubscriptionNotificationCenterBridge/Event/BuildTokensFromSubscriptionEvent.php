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

namespace Avisota\Contao\SubscriptionNotificationCenterBridge\Event;

use Avisota\Contao\Entity\Subscription;
use NotificationCenter\Model\Notification;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class Bridge
 */
class BuildTokensFromSubscriptionEvent extends Event
{
	/**
	 * @var Subscription
	 */
	protected $subscription;

	/**
	 * @var \ArrayObject
	 */
	protected $tokens;

	function __construct($subscription)
	{
		$this->subscription = $subscription;
		$this->tokens    = new \ArrayObject();
	}

	/**
	 * @return Subscription
	 */
	public function getSubscription()
	{
		return $this->subscription;
	}

	/**
	 * @return \ArrayObject
	 */
	public function getTokens()
	{
		return $this->tokens;
	}

	/**
	 * Add some tokens.
	 *
	 * @param array|\Traversable $tokens
	 */
	public function addTokens($tokens)
	{
		foreach ($tokens as $name => $value) {
			$this->tokens[$name] = $value;
		}
	}
}