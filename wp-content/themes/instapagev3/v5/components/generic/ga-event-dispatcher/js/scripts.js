(function () {
  'use_strict';

  /**
   * Init whole GA Events dispatcher logic
   *
   * @returns {void}
   */
  var init = function init() {
    document.addEventListener('discovery:google-analytics', function () {
      bindEventListeners();
    })
  }

  /**
   * Bind events to event dispatcher elements
   *
   * @returns {void}
   */
  var bindEventListeners = function bindEventListeners() {
    document.addEventListener('multistepform:stepcompletition', sendEventAboutStepCompletitionInMultiStepForm);
    var eventDispatchers = document.querySelectorAll('[data-ga-category]');

    eventDispatchers.forEach(function (eventDispatcher) {
      eventDispatcher.addEventListener('click', function (event) {
        dispatchGAEvent(event.currentTarget);
      })
    });
  };

  /**
   * Dispatch Google Analytics event based on event dispatcher element.
   * This elements needs to have set `data-ga-category`, `data-ga-action`
   * and `data-ga-label` elements.
   *
   * @param {HTMLElement} eventDispatcherElement
   * @returns {void}
   */
  var dispatchGAEvent = function dispatchGAEvent(eventDispatcherElement) {
    if (!eventDispatcherElement.dataset.gaCategory
      || !eventDispatcherElement.dataset.gaAction
      || !eventDispatcherElement.dataset.gaLabel
    ) {
      return;
    }

    ga('send', 'event', {
      eventCategory: eventDispatcherElement.dataset.gaCategory,
      eventAction: eventDispatcherElement.dataset.gaAction,
      eventLabel: eventDispatcherElement.dataset.gaLabel,
      transport: 'beacon'
    });
  };

  var sendEventAboutStepCompletitionInMultiStepForm = function trackStepCompletitionInMultiStepForm(event) {
    if (!(event.detail.stepNumber && event.detail.formName)) {
      return;
    }

    ga('send', 'event', {
      eventCategory: 'Multistep form',
      eventLabel: event.detail.formName,
      eventAction: 'Step ' + event.detail.stepNumber + ' completition',
      eventValue: event.detail.stepNumber,
      transport: 'beacon'
    });
  };

  init();
})();
