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

use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseBuildTokensEvent
 *
 * @package Avisota\Contao\SubscriptionNotificationCenterBridge\Event
 */
abstract class BaseBuildTokensEvent extends Event
{
    /**
     * @var \ArrayObject
     */
    protected $tokens;

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
