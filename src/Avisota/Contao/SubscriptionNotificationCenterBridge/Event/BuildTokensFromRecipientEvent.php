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

use Avisota\Contao\Subscription\Event\SubscribeEvent;
use Avisota\Contao\Subscription\SubscriptionEvents;
use Avisota\Recipient\RecipientInterface;
use NotificationCenter\Model\Notification;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class Bridge
 */
class BuildTokensFromRecipientEvent extends Event
{
    /**
     * @var mixed
     */
    protected $recipient;

    /**
     * @var \ArrayObject
     */
    protected $tokens;

    /**
     * BuildTokensFromRecipientEvent constructor.
     *
     * @param $recipient
     */
    function __construct($recipient)
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
