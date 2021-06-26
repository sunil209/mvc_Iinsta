<?php
/**
 * Component do not need any parameters passed,
 * in addition we made decision that it is not parametrized.
 *
 * @example Basic example
 * Component::render('v70/attribution-tracker');
 * @endexample
 *
 */

use \Instapage\Classes\Component;
use \Instapage\Components\v70\AttributionTracker\AttributionTrackerHubspotFieldNames;

?>

<fieldset style="display: none;">
    <?php
        foreach (array_keys(AttributionTrackerHubspotFieldNames::FIELDS) as $fieldName) {
            Component::render('input', 'hidden', [
                'name' => $fieldName
            ]);
        }
    ?>
</fieldset>
