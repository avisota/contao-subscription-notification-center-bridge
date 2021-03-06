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

/**
 * Class Bridge
 */
class BuildTokensFromSubscriptionEvent extends BaseBuildTokensEvent
{
    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * BuildTokensFromSubscriptionEvent constructor.
     *
     * @param $subscription
     */
    public function __construct($subscription)
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
}
