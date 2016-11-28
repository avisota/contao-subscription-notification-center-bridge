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

namespace Avisota\Contao\SubscriptionNotificationCenterBridge;

/**
 * Class Bridge
 */
class SubscriptionNotificationCenterBridgeEvents
{
    /**
     * The BUILD_TOKENS_FROM_SUBSCRIPTION event occurs when a subscription must converted into tokens,
     * when create a notification.
     *
     * The event listener method receives
     * a Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromSubscriptionEvent instance.
     *
     * @var string
     *
     * @api
     */
    const BUILD_TOKENS_FROM_SUBSCRIPTION =
        'avisota.subscription-notification-center-bridge.build-tokens-from-subscription';

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
    const BUILD_TOKENS_FROM_RECIPIENT =
        'avisota.subscription-notification-center-bridge.build-tokens-from-recipient';
}
