# Instapage v5 template static methods overview
## Table of content
  1. [Component](#component)
  1. [View](#view)
  1. [HtmlHelper](#htmlhelper)
  1. [StringHelper](#stringhelper)
 
## Component
Instapage\Classes\Component
#### `render($component = '', $variation = 'default', $params = array())`

**Parameters**
- $component (string) - name of a component to render.
- $variation (string)(Optional) - name of component's variation. Default value: 'default'.
- $params (array)(Optional) - array of parameters passed to component's template. 

## View
Instapage\Classes\View
#### `render($view = '', $variation = 'default', $params = array())`


**Parameters**
- $view (string) - name of a view to render.
- $variation (string)(Optional) - name of view's variation. Default value: 'default'.
- $params (array)(Optional) - array of parameters passed to view's template. 

## HtmlHelper
Instapage\Helpers\HtmlHelper
#### `renderAttributes($attributes)`

**Parameters**
- $attributes (array) - array of attributer to render in 'attributeName' => 'attributeValue' format.

**Return**
String with attributes rendered in attributeName="attributeValue" format.

## StringHelper
Instapage\Helpers\StringHelper
#### `toStudlyCaps($text, $separator = '-')`

**Parameters**
- $text (string) - text to transform to StudlyCaps.
- $separator (string) - a character after the separator will be set as upper case.

**Return**
String transformed to StudlyCaps

**Example**
```php
$result = StringHelper::toStudlyCaps('text-to-transform');
//$result == 'TextToTransform';
```
#### `getPathFromClassname($className, $dirOnly)`

**Parameters**
- $className (string) - class name.
- $separator (boolean) - whether whole path or just directory name should be returned. Default value: false.

**Return**
String with path to a class file or class directory.

**Example**
```php
$path = StringHelper::getPathFromClassname('Instapage\Classes\Component');
$directory = StringHelper::getPathFromClassname('Instapage\Classes\Component', true);

//$path == {templateDirecory}/v5/classes/Component.php
//$directory == {templateDirecory}/v5/classes
```
