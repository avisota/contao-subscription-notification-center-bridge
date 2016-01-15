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
use Avisota\Recipient\RecipientInterface;
use Contao\Doctrine\ORM\EntityAccessor;
use ContaoCommunityAlliance\Contao\Bindings\ContaoEvents;
use ContaoCommunityAlliance\Contao\Bindings\Events\Date\ParseDateEvent;
use Doctrine\Common\Collections\ArrayCollection;
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
            SubscriptionEvents::SUBSCRIBE                                              => 'subscribe',
            SubscriptionEvents::CONFIRM_SUBSCRIPTION                                   => 'confirm',
            SubscriptionEvents::UNSUBSCRIBE                                            => 'unsubscribe',
            SubscriptionNotificationCenterBridgeEvents::BUILD_TOKENS_FROM_SUBSCRIPTION => 'buildSubscriptionTokens',
        );
    }

    public function subscribe(SubscribeEvent $event)
    {
        $this->sendNotification('avisota_subscribe', $event->getSubscription());
    }

    public function confirm(ConfirmSubscriptionEvent $event)
    {
        $this->sendNotification('avisota_confirm_subscription', $event->getSubscription());
    }

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
        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $GLOBALS['container']['event-dispatcher'];

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
     * @param \ArrayObject $tokens
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

    public function buildSubscriptionTokens(BuildTokensFromSubscriptionEvent $event)
    {
        $eventDispatcher = $event->getDispatcher();

        $subscription = $event->getSubscription();
        $tokens       = $event->getTokens();

        $parseDateEvent = new ParseDateEvent($subscription->getUpdatedAt()->getTimestamp(), $GLOBALS['TL_CONFIG']['datimFormat']);
        $eventDispatcher->dispatch(ContaoEvents::DATE_PARSE, $parseDateEvent);
        $tokens['datetime'] = $parseDateEvent->getResult();

        $parseDateEvent = new ParseDateEvent($subscription->getUpdatedAt()->getTimestamp(), $GLOBALS['TL_CONFIG']['dateFormat']);
        $eventDispatcher->dispatch(ContaoEvents::DATE_PARSE, $parseDateEvent);
        $tokens['date'] = $parseDateEvent->getResult();

        $parseDateEvent = new ParseDateEvent($subscription->getUpdatedAt()->getTimestamp(), $GLOBALS['TL_CONFIG']['timeFormat']);
        $eventDispatcher->dispatch(ContaoEvents::DATE_PARSE, $parseDateEvent);
        $tokens['time'] = $parseDateEvent->getResult();

        /** @var EntityAccessor $entityAccessor */
        $entityAccessor = $GLOBALS['container']['doctrine.orm.entityAccessor'];

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
