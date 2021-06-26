var integrationsUIHelper = (function () {
  'use_strict';

  var $integrationGroups = jQuery('.v7-integrations-group-wrapper');

  /**
   * Find top right corner to be rounded, depending on the number of items
   *
   * @returns {void}
   */
  function calculateTopRightCorner(elements, elementsLength) {
    if (elementsLength >= 4) {
      elements.eq(2).addClass('v7-lg-top-right-corner');
      elements.eq(3).addClass('v7-xl-top-right-corner');
    } else if (elementsLength <= 3) {
      elements.last().addClass('v7-top-right-corner');
    }
  }

  /**
   * Find bottom left corner to be rounded, depending on the number of items
   *
   * @returns {void}
   */
  function calculateBottomLeftCorner(elements, elementsLength) {
    if (elementsLength % 3 === 0) {
      elements.eq(-3).addClass('v7-lg-bottom-left-corner');
    } else {
      elements.eq(-(elementsLength % 3)).addClass('v7-lg-bottom-left-corner');
    }

    if (elementsLength % 4 === 0) {
      elements.eq(-4).addClass('v7-xl-bottom-left-corner');
    } else {
      elements.eq(-(elementsLength % 4)).addClass('v7-xl-bottom-left-corner');
    }
  }

  /**
   * Remove added classes and prepare elements for recalculation
   *
   * @returns {void}
   */
  function resetIntegrationItemsCorner() {
    $integrationGroups.each(function() {
      var $integrations = jQuery(this).children();
      $integrations.removeClass(
        'v7-lg-bottom-left-corner v7-xl-bottom-left-corner v7-top-right-corner v7-lg-top-right-corner v7-xl-top-right-corner v7-bottom-right-corner v7-top-left-corner'
        );
    });
  }

  /**
   * Round all four corners of integrations group
   *
   * @returns {void}
   */
  function calculateIntegrationItemsCorner() {
    resetIntegrationItemsCorner();

    $integrationGroups.each(function() {
      // Exclude hidden elements so it can recalculate even on dynamic search
      var $integrations = jQuery(this).children().not('.v7-is-hidden');
      var integrationsLength = $integrations.length;

      $integrations.first().addClass('v7-top-left-corner');
      $integrations.last().addClass('v7-bottom-right-corner');
      calculateTopRightCorner($integrations, integrationsLength);
      calculateBottomLeftCorner($integrations, integrationsLength);
    });
  }

  /**
   * Hide integrations categories when they are empty after filtering
   *
   * @returns {void}
   */
  function hideFilteredElementsParent() {
    var parentSelector = '.v7-integration-category';
    var $filteredElementsParents = jQuery(parentSelector);

    $filteredElementsParents.each(function () {
      var $elements = jQuery(this).find('.js-filter-element');
      var hiddenElements = $elements.filter('.v7-is-hidden');

      if (hiddenElements.length === $elements.length) {
        jQuery(this).closest(parentSelector).addClass('is-hidden');
      } else {
        jQuery(this).closest(parentSelector).removeClass('is-hidden');
      }
    });
  }

  /**
   * Hide integrations categories when they are empty after filtering
   *
   * @returns {void}
   */
  function toggleIntegrationDescription() {
    var $integration = jQuery('.v7-integration');

    $integration.on('click', function(event) {
      var integrationHeader = event.target;
      jQuery(integrationHeader).closest('.v7-integration').toggleClass('v7-integration-open');
    });
  }

   /**
   * Add Loader on the integration page
   *
   * @returns {void}
   */
  function showLoaderOnLogos() {
    var $filterGroup = jQuery('.grid-filter-group');
    var $filterElement = jQuery('.js-filter-element');

    setTimeout(function () {
          $filterGroup.addClass('active-grid');
          $filterElement.fadeTo( "slow", 1 );
      }, 400);
  }

  jQuery(document).ready(function() {
    showLoaderOnLogos();
    calculateIntegrationItemsCorner();
    hideFilteredElementsParent();
    toggleIntegrationDescription();
  });

  return {
    calculateVisible: calculateIntegrationItemsCorner,
    hideCategories: hideFilteredElementsParent
  };
})(jQuery);
