# DNext - Form Builder

## Table of Contents
- [DNext - Form Builder](#dnext---form-builder)
    - [Table of Contents](#table-of-contents)
    - [Overview](#overview)
    - [Prerequisites](#prerequisites)
    - [Module Features](#module-features)
        - [Fields and Properties](#fields-and-properties)
        - [Extension Options](#extension-options)

---

## Overview
The DNext Form Builder module enhances Drupal's form capabilities by integrating with the [react-jsonschema-form](https://github.com/rjsf-team/react-jsonschema-form) NPM package, providing a powerful and flexible way to build forms based on JSON schema.

---

## Prerequisites
Ensure your Drupal environment meets the following requirements:
- Drupal 10 or higher.
- Webform module installed and enabled.
- Basic knowledge of JSON schema.

---

## Module Features
DNext Form Builder extends the [Webform JSON Schema module](https://www.drupal.org/project/webform_jsonschema), enabling the use of Drupal webforms with the react-jsonschema-form NPM package. It adds additional properties to a selection of standard Drupal form fields and removes HTML markup from field validation messages for a cleaner user experience.

### Fields and Properties
Extended fields include:
- textfield
- textarea
- email
- number

Basic properties for these fields:
- minlength
- maxlength
- rows
- pattern

UI properties for enhanced user interaction:
- placeholder
- autocomplete
- readonly
- disabled

### Extension Options
To further extend field properties:
- Modify `FIELDS_PROPERTIES` or `FIELDS_UI_PROPERTIES` arrays in the `TransformerExtended` class within the DNext - Form Builder module.
- Develop custom Drupal webform fields implementing `JsonSchemaElementInterface` from the Webform JSON Schema module for additional customization.
