/**
 * Revealing module for load more content ajax functionality
 */

var loadMoreContentAjax = (function() {
  'use_strict';

  /**
   * Url of ajax endpoint
   *
   * @type String
   */
  var ajax_url = '/wp-admin/admin-ajax.php';

  /**
   * Object containing all needed dom elements selectors
   *
   * @type object
   */
  var selectors = {
    loadMoreButton: '.js-load-more-button',
    placeToLoadMoreContent: '#js-load-more-content',
    loadMoreContainer: '.js-load-more',
    loaderIndicator: '.js-loader',
    traditionalPagination: '.js-traditional-pagination-wrapper'
  };

  /**
   * Object containg all jQuery object for later reference
   *
   * @type object
   */
  var $elements = {
    loadMoreButton: null,
    placeToLoadMoreContent: null,
    loadMoreContainer: null,
    loaderIndicator: null,
    traditionalPagination: null
  };

  // internal state of module
  var pageToLoadNumber = null;
  var postTypesToLoad = null;
  var maxPageNumber = null;
  var authorID = null;
  var categoryName = null;
  var searchQuery = null;
  var searchType = null;

  /**
   * This mutex is responsible for one loading of new content at the time
   *
   * @type Boolean
   */
  var loadingMutex = false;

  /**
   * Starts up all needed elements.
   *
   * @returns {void}
   */
  var init = function init() {
    hookElements();
    initInternalVariables();
    initFrontEndLayer();
    bindEventListeners();
  };

  /**
   * Get jQuery objects of all needed elements, and store them for later reference.
   *
   * @returns {void}
   */
  var hookElements = function hookElements() {
    $elements.loadMoreButton = jQuery(selectors.loadMoreButton);
    $elements.placeToLoadMoreContent = jQuery(selectors.placeToLoadMoreContent);
    $elements.loadMoreContainer = jQuery(selectors.loadMoreContainer);
    $elements.loaderIndicator = jQuery(selectors.loaderIndicator);
    $elements.traditionalPagination = jQuery(selectors.traditionalPagination);
  };

  /**
   * Set load more UI, show load more button or hide when needed
   *
   * @returns {void}
   */
  var setLoadMoreUI = function setLoadMoreUI() {
    // if there are still pages to load show button for that
    if (pageToLoadNumber <= maxPageNumber) {
      $elements.loadMoreButton.removeState('hidden');
      $elements.loadMoreContainer.css('display', 'block');
      $elements.loaderIndicator.addState('hidden');
    } else {
      // there are no pages to load,
      // hide whole functionality for dynamic loading of content
      $elements.loadMoreContainer.css('display', 'none');
    }
  }

  /**
   * Do all necessary initialization in DOM
   *
   * Show load more content button etc
   *
   * @returns {void}
   */
  var initFrontEndLayer = function initFrontEndLayer() {
    setLoadMoreUI();
    $elements.traditionalPagination.addState('hidden');
  };

  /**
   * Init all needed variables for effective loadign more content by ajax
   *
   * @returns {void}
   */
  var initInternalVariables = function initInternalVariables() {
    pageToLoadNumber = $elements.placeToLoadMoreContent.data('current-page') + 1;
    postTypesToLoad = $elements.placeToLoadMoreContent.data('post-types');
    maxPageNumber = $elements.placeToLoadMoreContent.data('max-page-number');
    authorID = $elements.placeToLoadMoreContent.data('author-id');
    categoryName = $elements.placeToLoadMoreContent.data('category-name');
    searchQuery = $elements.placeToLoadMoreContent.data('search-query');
    searchType = $elements.placeToLoadMoreContent.data('search-type');
  };

  /**
   * Bind all needed listeners
   *
   * @returns {void}
   */
  var bindEventListeners = function bindEventListeners() {
    $elements.loadMoreButton.click(function(event) {
      event.preventDefault();
      loadMoreContent();
    });
  };

  /**
   * UI changes when loading of content has started
   *
   * @returns {undefined}
   */
  var startLoading = function startLoading() {
    $elements.loadMoreButton.addState('hidden');
    $elements.loaderIndicator.removeState('hidden');
  };

  /**
   * Alter UI when loading of new content is finished
   *
   * This method change only UI, not state of module!
   *
   * @returns {void}
   */
  var endLoading = function endLoading() {
    setLoadMoreUI();
  };

  /**
   * Method for complex handling of load more content action
   *
   * @returns {void}
   */
  var loadMoreContent = function loadMoreContent() {
    // we are performing only one load more content action at the time
    if (loadingMutex) {
      return;
    }
    loadingMutex = true;
    startLoading();

    getMoreContentFromAPI()
      // data from API is successfully collected, using promises
      .done(function(data) {
        processAPIResponse(data);
      });
  };

  /**
   * Call to our API for more content
   *
   * @returns {jqXHR}
   */
  var getMoreContentFromAPI = function getMoreContentFromAPI() {
    var data = {
      action: 'load_more_content',
      pageToLoadNumber: pageToLoadNumber,
      postTypesToLoad: postTypesToLoad
    };

    // if this is author listing page add also authorID to fetch only proper posts
    if (authorID !== null && authorID !== undefined) {
      data.authorID = authorID;
    }

    // if this is category listing page add also category name to fetch only proper posts
    if (categoryName !== null && categoryName !== undefined) {
      data.categoryName = categoryName;
    }

    // if this is search listing page add also search query to fetch only proper posts
    if (searchQuery !== null && searchQuery !== undefined) {
      data.searchQuery = searchQuery;
    }

    // if this is search with type specified
    if (searchType !== null && searchType !== undefined) {
      data.searchType = searchType;
    }

    return jQuery.get(
       ajax_url,
       data
    );
  };

  /**
   * Check if response from API is in correct format
   *
   * @param {object} responseData
   * @returns {boolean}
   */
  var checkAPIResponse = function checkAPIResponse(responseData) {
    return  responseData.success
            && responseData.hasOwnProperty('data')
            && responseData.data.hasOwnProperty('posts')
            && Array.isArray(responseData.data.posts);
  };

  /**
   * We have response from our API, process it in proper manner and do all after action
   *
   * @param {object} responseData
   * @returns {undefined}
   */
  var processAPIResponse = function processAPIResponse(responseData) {
    if(checkAPIResponse(responseData)) {
      var postsNumber = responseData.data.posts.length;
      for (var i = 0; i < postsNumber; i++) {
        $elements.placeToLoadMoreContent.append(
          responseData.data.posts[i]
        );
      }
      loadingComplete();
      endLoading();
    }
  };

  /**
   * Do all necessary actions after properly loaded content.
   *
   * Increase next page to load, release mutex.
   *
   * @returns {void}
   */
  var loadingComplete = function loadingComplete() {
    pageToLoadNumber++;
    loadingMutex = false;
  };

  // reveal only neccessary method, others are private
  return {
    init: init
  };
})();

jQuery(document).ready(function() {
    loadMoreContentAjax.init();
});
