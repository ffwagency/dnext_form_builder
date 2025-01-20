<?php

namespace Drupal\dnext_form_builder;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\webform\Entity\Webform;

/**
 * Extended transforing of webform to JSON Schema transformation.
 *
 * This class is used to extend the functionality of the webform_jsonschema module.
 * It adds the ability to alter the schema and UI schema of the webform elements.
 *
 */
class TransformerExtended {

  /**
   * @var ModuleHandlerInterface $moduleHandler
   */
  protected $moduleHandler;

  /**
   * @var array $fieldsProperties
   */
   protected const FIELDS_PROPERTIES = [
    'textfield' => [
      '#minlength' => 'minLength',
      '#maxlength' => 'maxLength',
    ],
    'textarea' => [
      '#minlength' => 'minLength',
      '#maxlength' => 'maxLength',
      '#rows' => 'rows',
    ],
    'email' => [
      '#minlength' => 'minLength',
      '#maxlength' => 'maxLength',
      '#pattern'  => 'pattern',
    ],
  ];

  /**
   * @var array $fieldsUiProperties
   */
  protected const FIELDS_UI_PROPERTIES = [
    'textfield' => [
      '#placeholder' => 'ui:placeholder',
      '#autocomplete' => 'ui:autocomplete',
      '#disabled' => 'ui:disabled',
      '#readonly' => 'ui:readonly',
    ],
    'textarea' => [
      '#placeholder' => 'ui:placeholder',
      '#autocomplete' => 'ui:autocomplete',
      '#disabled' => 'ui:disabled',
      '#readonly' => 'ui:readonly',
    ],
    'email' => [
      '#placeholder' => 'ui:placeholder',
      '#autocomplete' => 'ui:autocomplete',
      '#disabled' => 'ui:disabled',
      '#readonly' => 'ui:readonly',
    ],
    'number' => [
      '#placeholder' => 'ui:placeholder',
      '#autocomplete' => 'ui:autocomplete',
      '#disabled' => 'ui:disabled',
      '#readonly' => 'ui:readonly',
    ],
    'checkboxes' => [
      '#disabled' => 'ui:disabled',
    ],
  ];

  /**
   * TransformerExtended constructor.
   *
   *
   * @param ModuleHandlerInterface $moduleHandler
   */
  public function __construct(ModuleHandlerInterface $moduleHandler) {
    $this->moduleHandler = $moduleHandler;
  }

  /**
   * Transforms a webform to JSON Schema.
   *
   * @param array $generalSchema
   *
   * @param Webform $webform
   *
   * @return array
   */
  public function toJsonSchemaExtended(array $generalSchema, Webform $webform): array {
    $schema = $this->itemsToSchemaExtended($generalSchema, $webform->getElementsInitialized());

    return $schema;
  }

  /**
   * Creates a JSON Schema out of Webform elements array.
   *
   * @param array $schema
   * @param array $items
   *
   * @return array
   */
  protected function itemsToSchemaExtended(array $schema, array $items): array {
    foreach ($items as $key => $item) {
        $itemType = $item['#type'] ?? '';
        $fieldsProperties = self::FIELDS_PROPERTIES[$itemType] ?? [];

        foreach (($item->element) as $elementKey => $elementValue) {
          if (!empty($fieldsProperties) && isset($fieldsProperties[$elementKey])) {
            $schema['properties'][$key][$fieldsProperties[$elementKey]] = $elementValue;
          }
        }
    }

    return $schema;
  }

  /**
   * Transforms a webform to UI Schema.
   *
   * @param array $uiSchemaGeneral
   * @param Webform $webform
   *
   * @return array
   */
  public function toUiSchemaExtended( array $uiSchemaGeneral, Webform $webform): array {
    $uiSchema = $this->itemsToUiSchemaExtended($uiSchemaGeneral, $webform->getElementsInitialized());

    return $uiSchema;
  }

  /**
   * Creates a UI Schema out of WebformItem's.
   *
   * @param array $items
   * @param array $uiSchema
   *
   * @return array
   */
  protected function itemsToUiSchemaExtended(array $uiSchema, array $items): array {
    foreach ($items as $key => $item) {
      $itemType = $item['#type'];
      $fieldsUiProperties = self::FIELDS_UI_PROPERTIES[$itemType] ?? [];

      foreach (($item) as $elementKey => $elementValue) {
        if (!empty($fieldsUiProperties) && isset($fieldsUiProperties[$elementKey])) {
          $uiSchema[$key][$fieldsUiProperties[$elementKey]] = $elementValue;
        }
      }

      if ($item['#type'] === 'checkboxes' && !empty($fieldsUiProperties)) {
        $uiSchema[$key]['ui:disabled'] = $item['#disabled'];
      }
    }

    return $uiSchema;
  }
}
