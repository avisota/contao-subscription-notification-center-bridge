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

    /**
     * BuildTokensFromSubscriptionEvent constructor.
     *
     * @param $subscription
     */
    function __construct($subscription)
    {
        $this->subscription = $subscription;
        $this->tokens       = new \ArrayObject();
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
