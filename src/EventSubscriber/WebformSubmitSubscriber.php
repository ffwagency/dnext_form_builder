<?php

namespace Drupal\dnext_form_builder\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\webform_rest\Event\WebformSubmitReturnEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class WebformSubmitSubscriber implements EventSubscriberInterface {

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  public function __construct( EventDispatcherInterface $event_dispatcher) {
    $this->eventDispatcher = $event_dispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[WebformSubmitReturnEvent::WEBFORM_SUBMIT_RETURN][] = ['onWebformSubmitReturn', 200];

    return $events;
  }

  /**
   * Responds to the webform submit return event.
   *
   * @param WebformSubmitReturnEvent $event
   *   The event object.
   */
  public function onWebformSubmitReturn(WebformSubmitReturnEvent $event) {
    // Get the return data from the event
    $returnData = &$event->getReturnData();
    // Check if the 'error' key exists and is an array
    if (isset($returnData['error']) && is_array($returnData['error'])) {
      $returnData = $this->stripHtmlFromErrors($returnData);
    }
  }

  /**
   * Strips HTML tags from error messages array.
   *
   * @param array $returnData
   *   The webform errors to process.
   *
   * @return array
   *   The array with HTML tags stripped from error messages.
   */
  protected function stripHtmlFromErrors(array $returnData) : array {

    // Iterate over each error value and strip HTML tags
    foreach ($returnData['error'] as $key => $value) {
      $returnData['error'][$key] = strip_tags($value);
    }

    // Return the modified array as a JSON string
    return $returnData;
  }
}
