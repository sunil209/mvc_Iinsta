var InstapageModal = function (options) {
    this.options = options;
    this.defaults = {
      modal: '.js-modal',
      trigger: '.js-modal-trigger',
      closingElements: '.js-modal-close, .js-modal',
      dim: '.dim',
      lock: 'locked',
      hiddenState: 'hidden',
      visibleState: 'visible'
    };
    Object.assign(this, _.extend(this.defaults, this.options));
  };
  
  InstapageModal.prototype.init = function () {
    if (!jQuery(this.modal)[0]) {
      return false;
    }
  
    var scope = this;
  
    jQuery(scope.trigger).on('click', function (e) {
      e.preventDefault();
      var activeModalSelector = '.' + jQuery(this).data('modal-id');

      jQuery(jQuery(activeModalSelector)).removeState(scope.hiddenState);
      jQuery(scope.dim).addState(scope.visibleState);
      jQuery('body').addState(scope.lock);
    });
  
    jQuery(scope.closingElements).on('click', function (e) {
      if (e.target !== e.currentTarget) return;
      jQuery(scope.modal).addState(scope.hiddenState);
      jQuery(scope.dim).removeState(scope.visibleState);
      jQuery('body').removeState(scope.lock);
    });
  
    jQuery(document).on('keyup', function (e) {
      if (!jQuery(scope.modal).hasState(scope.hiddenState)) {
          var keyCodeESC = 27;
          var modalTriggerClose = jQuery(scope.closingElements);
  
          if (e.keyCode === keyCodeESC) {
            jQuery(modalTriggerClose).click();
          }
        }
    });
  };

var simpleNonceInjector = (function() {
  'use strict';
  
  var ajax_url = '/wp-admin/admin-ajax.php';
  
  /**
   * Instance of form object to handle all nonce related things
   * 
   * @param {jQuery} $placeToInjectNonce // place to inject nonce, it is empty div, content will be replace if there any will be
   * @returns {scriptmodalSimpleNonceInjector.Form}
   */
  function Form($placeToInjectNonce) {
    this.$placeToInjectNonce = $placeToInjectNonce;
    // get form to inject nonce to it
    this.$form = this.$placeToInjectNonce.closest('form');
    // get input triggering injecting nonce when user start to typing text in it
    this.$inputTiggeringSimpleNonceInjection = this.$form.find('input[required]').first();
    /**
     * nonceMutex guarantee that there is only once ajax call for nonce
     * 
     * @type Boolean
     */
    this.nonceMutex = false;
    this.nonceName = '';
    
    // init all stuff relate
    this.init();
  }
  
  /**
   * Initialize injecting nonce for given form
   * 
   * @returns {void}
   */
  Form.prototype.init = function init() {
    this.getNonceNameFromHtml();
    // only if nonce name is proper init event listeners
    if (this.nonceName !== '') {
      this.bindEventListeners();
      this.nonceAutocomplete();
    }
  };
  
  /**
   * Method for getting and setting in form nonce name to generate.
   * 
   * Method gets name of nonce from data-nonce-name attribute on this.$placeToInjectNonce element.
   * Default: $placeToInjectNonce is element with id js-nonce
   * 
   * @returns {void}
   */
  Form.prototype.getNonceNameFromHtml = function getNonceNameFromHtml() {
    var dataNonceName = this.$placeToInjectNonce.data('nonce-name');
    if (dataNonceName !== undefined) {
      this.nonceName = dataNonceName;
    }
  };
  
  /**
   * Method for injecting nonce html to the form
   * 
   * @param {object} response - Object fetched from our API containing all necessary information for injecting nonce.
   * @returns {void}
   */
  Form.prototype.injectNonce = function injectNonce(response) {
    if (
        response.data.status !== undefined 
        && response.data.status === 'verified'
        && response.data.payload !== undefined
    ) {
      var nonceHTML = response.data.payload;
      this.$placeToInjectNonce.html(nonceHTML);
    }
  };
  
  /**
   * Try to get nonce from our API, if success run injectNonce function.
   * 
   * Method assumes that nonceName is set for something diffrent than empty string, 
   * cannot be called without calling getNonceNameFromHtml earlier.
   * 
   * @returns {void}
   */
  Form.prototype.getNonceFromAPI = function getNonceFromAPI() {
    // mutex is to try get nonce only once
    if (this.nonceMutex) {
      return;
    }
    this.nonceMutex = true;
    
    var data = {
      action: 'simple_nonce_ajax_get_nonce',
      nonceName: this.nonceName
    };
    
    jQuery.post(
      ajax_url, 
      data,
      this.injectNonce.bind(this),
      'json'
    );
  };
  
  /**
   * Bind all needed listeners
   * 
   * @returns {void}
   */
  Form.prototype.bindEventListeners = function bindEventListeners() {
    // bind listener to input, when user start to fill in form get nonce by AJAX and try to inject
    this.$inputTiggeringSimpleNonceInjection.change(this.getNonceFromAPI.bind(this));
  };
  
  /**
   * Get nonce when is backend error after form submitting 
   * 
   * @returns {void}
   */
  Form.prototype.nonceAutocomplete = function nonceAutocomplete() {
    if (this.$placeToInjectNonce.data('nonce-autocomplete') !== undefined) {
      this.getNonceFromAPI();
    }
  };    

  /**
   * Method for initialization modalSimpleNonceInjector
   * 
   * @returns {void}
   */
  var initForms = function initForms() {
    jQuery('.js-nonce').each(function() {
      new Form(jQuery(this));
    });
  };
  
  // Reveal only certain methods to the global scope
  return {
    initForms: initForms
  };
})();

jQuery(document).ready(function() {
  simpleNonceInjector.initForms();
});
