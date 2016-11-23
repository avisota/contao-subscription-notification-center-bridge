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

/**
 * Class Bridge
 */
class BuildTokensFromRecipientEvent extends BaseBuildTokensEvent
{
    /**
     * @var mixed
     */
    protected $recipient;

    /**
     * BuildTokensFromRecipientEvent constructor.
     *
     * @param $recipient
     */
    public function __construct($recipient)
    {
        $this->recipient = $recipient;
        $this->tokens    = new \ArrayObject();
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
}
