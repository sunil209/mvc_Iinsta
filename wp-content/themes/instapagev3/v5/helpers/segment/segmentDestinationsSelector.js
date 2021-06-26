/**
 * Revealing module for selecting segment destination based on urls
 */
var segmentDestinationsSelector = (function () {
  /**
   * Object holding integration settings, on wich page given intergration should be load?
   * Notice: If integration is not listed here and is plugged in in segment it will be fired on every page
   *
   * @type {{intergrations: {string: {onlyOnPagePaths: string[]}}}}
   */
  var settings = {
    intergrations: {
      'Intercom': {
        notOnPagePaths: [
          '^/$',
          '^/blog',
          '^/start$',
          '^/home$',
          '^/landing-page-templates',
          '^/contact$'
         ]
      },
      "Ambassador": {
        onlyOnPagePaths: [
          '^/enterprise-thank-you'
        ]
      }
    }
  }

  /**
   * Returns object containing integration name as a key and value set to bool,
   * if true load this integration with segment if false do not load
   *
   * @returns {object}
   */
  var getListOfIntegrationToLoadOnCurrentPage = function getListOfIntegrationToLoadOnCurrentPage() {
    var segmentIntegrationsConfig = {};

    // iterate trought all integration definition
    for (var integration in settings.intergrations) {
      if (!settings.intergrations.hasOwnProperty(integration)) {
        continue;
      }

      // check all rules for given integration, does it have rules to load only on given pages?
      if (settings.intergrations[integration].hasOwnProperty('onlyOnPagePaths')) {
        segmentIntegrationsConfig[integration] =
          isCurrentPageUrlMatchingRules(settings.intergrations[integration]['onlyOnPagePaths']);
      }

      // check all rules for given integration, does it have rules to NOT load on given pages?
      if (settings.intergrations[integration].hasOwnProperty('notOnPagePaths')) {
        segmentIntegrationsConfig[integration] =
          !isCurrentPageUrlMatchingRules(settings.intergrations[integration]['notOnPagePaths']);
      }

    }

    return segmentIntegrationsConfig;
  }

  /**
   * Check if current url page match atleast once regex from rules array
   *
   * @param rules string[] Array of regex strings
   * @returns {boolean}
   */
  var isCurrentPageUrlMatchingRules = function isCurrentPageUrlMatchingRules(rules) {
    var currentPageUrl = window.location.pathname;
    var rulesCount = rules.length;
    var testResult = false;
    var regex;

    for (var i = 0; i < rulesCount; i++) {
      regex = RegExp(rules[i]);
      testResult = regex.test(currentPageUrl);

      if (testResult === true) {
        break;
      }
    }

    return testResult;
  }

  // reveal only necessary methods, others are private
  return {
    getListOfIntegrationToLoadOnCurrentPage:  getListOfIntegrationToLoadOnCurrentPage
  };
})();
