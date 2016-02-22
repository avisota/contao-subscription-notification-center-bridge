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

use Avisota\Contao\Entity\Subscription;
use Avisota\Contao\Subscription\Event\ConfirmSubscriptionEvent;
use Avisota\Contao\Subscription\Event\ResolveRecipientEvent;
use Avisota\Contao\Subscription\Event\SubscribeEvent;
use Avisota\Contao\Subscription\Event\UnsubscribeEvent;
use Avisota\Contao\Subscription\SubscriptionEvents;
use Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromRecipientEvent;
use Avisota\Contao\SubscriptionNotificationCenterBridge\Event\BuildTokensFromSubscriptionEvent;
use Contao\Doctrine\ORM\EntityAccessor;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Date\ParseDateEvent;
use NotificationCenter\Model\Notification;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Bridge
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Bridge implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            SubscriptionEvents::SUBSCRIBE => array(
                array('subscribe'),
            ),

            SubscriptionEvents::CONFIRM_SUBSCRIPTION => array(
                array('confirm'),
            ),

            SubscriptionEvents::UNSUBSCRIBE => array(
                array('unsubscribe'),
            ),

            SubscriptionNotificationCenterBridgeEvents::BUILD_TOKENS_FROM_SUBSCRIPTION => array(
                array('buildSubscriptionTokens'),
            ),
        );
    }

    /**
     * @param SubscribeEvent $event
     */
    public function subscribe(SubscribeEvent $event)
    {
        $this->sendNotification('avisota_subscribe', $event->getSubscription());
    }

    /**
     * @param ConfirmSubscriptionEvent $event
     */
    public function confirm(ConfirmSubscriptionEvent $event)
    {
        $this->sendNotification('avisota_confirm_subscription', $event->getSubscription());
    }

    /**
     * @param UnsubscribeEvent $event
     */
    public function unsubscribe(UnsubscribeEvent $event)
    {
        $this->sendNotification('avisota_unsubscribe', $event->getSubscription());
    }

    /**
     * @param Subscription $subscription
     *
     * @return \ArrayObject
     */
    protected function buildTokens(Subscription $subscription)
    {
        global $container;

        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $container['event-dispatcher'];

        $event = new ResolveRecipientEvent($subscription);
        $eventDispatcher->dispatch(SubscriptionEvents::RESOLVE_RECIPIENT, $event);

        $recipient = $event->getRecipient();

        $tokens = new \ArrayObject();

        $event = new BuildTokensFromSubscriptionEvent($subscription);
        $eventDispatcher->dispatch(SubscriptionNotificationCenterBridgeEvents::BUILD_TOKENS_FROM_SUBSCRIPTION, $event);

        foreach ($event->getTokens() as $key => $value) {
            $tokens[$key] = $value;
        }

        $event = new BuildTokensFromRecipientEvent($recipient);
        $eventDispatcher->dispatch(SubscriptionNotificationCenterBridgeEvents::BUILD_TOKENS_FROM_RECIPIENT, $event);

        foreach ($event->getTokens() as $key => $value) {
            $tokens[$key] = $value;
        }

        return $tokens;
    }

    /**
     * @param string       $type
     * @param Subscription $subscription
     *
     * @internal param \ArrayObject $tokens
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    protected function sendNotification($type, Subscription $subscription)
    {
        $tokens                 = $this->buildTokens($subscription);
        $notificationCollection = Notification::findBy('type', $type);
        if (null !== $notificationCollection) {
            while ($notificationCollection->next()) {
                $notification = $notificationCollection->current();

                if ($notification->avisotaFilterByMailingList) {
                    $mailingListId        = $subscription->getMailingList()
                        ? $subscription->getMailingList()->getId()
                        : null;
                    $selectedMailingLists = deserialize($notification->avisotaFilteredMailingLists, true);

                    if (!in_array($mailingListId, $selectedMailingLists)) {
                        continue;
                    }
                }

                /** @var Notification $notification */
                $notification->send($tokens->getArrayCopy());
            }
        }
    }

    /**
     * @param BuildTokensFromSubscriptionEvent $event
     */
    public function buildSubscriptionTokens(BuildTokensFromSubscriptionEvent $event)
    {
        global $container;

        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $container['event-dispatcher'];

        $subscription = $event->getSubscription();
        $tokens       = $event->getTokens();

        $parseDateEvent = new ParseDateEvent(
            $subscription->getUpdatedAt()->getTimestamp(),
            \Config::get('datimFormat')
        );
        $eventDispatcher->dispatch(ContaoEvents::DATE_PARSE, $parseDateEvent);
        $tokens['datetime'] = $parseDateEvent->getResult();

        $parseDateEvent = new ParseDateEvent(
            $subscription->getUpdatedAt()->getTimestamp(),
            \Config::get('dateFormat')
        );
        $eventDispatcher->dispatch(ContaoEvents::DATE_PARSE, $parseDateEvent);
        $tokens['date'] = $parseDateEvent->getResult();

        $parseDateEvent = new ParseDateEvent(
            $subscription->getUpdatedAt()->getTimestamp(),
            \Config::get('timeFormat')
        );
        $eventDispatcher->dispatch(ContaoEvents::DATE_PARSE, $parseDateEvent);
        $tokens['time'] = $parseDateEvent->getResult();

        /** @var EntityAccessor $entityAccessor */
        $entityAccessor = $container['doctrine.orm.entityAccessor'];

        $properties = $entityAccessor->getProperties($subscription);

        foreach ($properties as $key => $value) {
            if (!is_object($value)) {
                $tokens['subscription_' . $key] = $value;
            }
        }

        $mailingList = $subscription->getMailingList();

        if ($mailingList) {
            $properties = $entityAccessor->getProperties($mailingList);

            foreach ($properties as $key => $value) {
                if (!is_object($value)) {
                    $tokens['mailing_list_' . $key] = $value;
                }
            }
        } else {
            $tokens['mailing_list_id']    = 0;
            $tokens['mailing_list_title'] = 'global';
        }
    }
}
