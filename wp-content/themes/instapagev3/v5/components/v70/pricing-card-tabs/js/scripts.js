;(function () {
    'use_strict';
  
    /**
     * Url of ajax endpoint
     *
     * @type String
     */
    var ajax_url = '/wp-admin/admin-ajax.php';

    /**
     * Plan Type Constant
     *
     * @type object
     */
     var planTypeConstant = {
         monthly : 'monthly',
         annually : 'annually'
     };

    /**
     * Plan Type
     *
     * @type String
     */
     var planType = planTypeConstant.annually;

    /**
     * Object containing all needed dom elements selectors
     *
     * @type object
     */
    var planSelectors = {
        planButton: '.plan-tracking',
        tabButtonActiveClass: 'v7-tab-active-content'
    };

    /**
     * Object containing all button Attribute
     *
     * @type object
     */
    var planButtonAttr = {
        planTypeAttr: 'data-plan',
        planMonthlyAttr: 'data-monthly',
        planAnnualAttr: 'data-annually',
        utmPlanMonthlyAttr: 'data-utm-monthly',
        utmPlanAnnualAttr: 'data-utm-annually',
        planUrlAttr: 'data-url'
    }

    var init = function init() {

        
        var switchButton 			= document.querySelector('.switch-button');
        var switchBtnRight 			= document.querySelector('.switch-button-case.right');
        var switchBtnLeft 			= document.querySelector('.switch-button-case.left');
        var activeSwitch 			= document.querySelector('.active');
        var pricingTabSection 		= document.getElementById('v7-pricing-tabs-section');
      
        function switchLeft(){
            planType = planTypeConstant.monthly;
            switchBtnRight.classList.remove('active-case');
            switchBtnLeft.classList.add('active-case');
          
            if(pricingTabSection){
                pricingTabSection.classList.remove('v7-annually-active');
                pricingTabSection.classList.add('v7-monthly-active');
            }
            setButtonLinkAttribute(planType);
        }

        function switchRight(){
            planType = planTypeConstant.annually;
            switchBtnRight.classList.add('active-case');
            switchBtnLeft.classList.remove('active-case');
        
            if(pricingTabSection){
                pricingTabSection.classList.remove('v7-monthly-active');
                pricingTabSection.classList.add('v7-annually-active');
            }
            setButtonLinkAttribute(planType);
        }


        function mobileTabPricing(){
            if (jQuery(window).width() < 1170) {
                jQuery('#v7-price-card-header .v7-price-col-right .v7-price-col').click(function(event){
                    jQuery('#v7-price-card-header .v7-price-col').removeClass('v7-mob-active-tab');
                    jQuery(this).addClass('v7-mob-active-tab');

                    var getTabString = jQuery(this).data('tabname');
                    var activeTabString = '.v7-price-'+getTabString+'-col';

                    jQuery('#v7-accordion-container .v7-price-description-wrap').removeClass('v7-tab-active-content');
                    jQuery('#v7-price-card-footer .v7-price-head-text').removeClass('v7-mob-active-tab');
                    jQuery('#v7-price-card-footer .v7-price-tab').removeClass('v7-tab-active-content');

                    jQuery('#v7-mob-switch-btn .v7-price-discount-mob').removeClass('v7-tab-active-content');

                    jQuery('#v7-mob-switch-btn .v7-price-discount-mob'+activeTabString).addClass('v7-tab-active-content');
                    
                    jQuery('#v7-accordion-container .v7-price-description-wrap'+activeTabString).addClass('v7-tab-active-content');
                    jQuery('#v7-price-card-footer .v7-price-head-text'+activeTabString).addClass('v7-mob-active-tab');
                    jQuery('#v7-price-card-footer .v7-price-tab'+activeTabString).addClass('v7-tab-active-content');
                     
                    jQuery('.v7-price-building-col').removeClass( planSelectors.tabButtonActiveClass );
                    jQuery('.v7-price-building-col.v7-price-footer-' + getTabString).addClass( planSelectors.tabButtonActiveClass );

                    event.preventDefault();
                });
            }
        }


        function isOutOfViewport (elem) { 
            if(elem){
                var bounding = elem.getBoundingClientRect();
                var out = {};
                out.top = bounding.top < 0;
                out.left = bounding.left < 0;
                out.bottom = bounding.bottom > (window.innerHeight+50 || document.documentElement.clientHeight+50);
                out.right = bounding.right > (window.innerWidth || document.documentElement.clientWidth);
                out.any = out.top || out.left || out.bottom || out.right;
                out.all = out.top && out.left && out.bottom && out.right;
                return out;
            }
        };

        function stickyButtonWithTabText(){

            var getPricingSection = document.querySelector('#v7-pricing-tabs-section');
            if(getPricingSection){
                var isVisibleInPort   = isOutOfViewport(getPricingSection);
                var getScrollPosition = jQuery(window).scrollTop();
                if (getScrollPosition >= 110) {
                        if (isVisibleInPort.bottom) 
                            {
                                jQuery('#v7-price-card-footer').addClass('v7-price-card-footer-fixed');
                            }
                        else
                            {
                                jQuery('#v7-price-card-footer').removeClass('v7-price-card-footer-fixed');
                            }
                    } 
                else 
                    {
                        jQuery('#v7-price-card-footer').removeClass('v7-price-card-footer-fixed');
                    }

            }

        }

        mobileTabPricing();


        window.addEventListener('scroll', function(event) {
            stickyButtonWithTabText();
        }, false);

        
        if(switchBtnLeft){
            switchBtnLeft.addEventListener('click', function(){
                switchLeft();
            }, false);
        }

        if(switchBtnRight){
            switchBtnRight.addEventListener('click', function(){
                switchRight();
            }, false);
        }


        jQuery(".v7-accordion-container .v7-accordion-set > a").on("click", function () {
            if (jQuery(this).parent().hasClass("active")) {
                jQuery(this).parent().removeClass("active");
            } else {
                // jQuery(".v7-accordion-set > a").parent().removeClass("active");
                 jQuery(this).parent().addClass("active");
            }

        });


        if (jQuery(window).width() < 768) {
            jQuery(".v7-accordion-container .v7-accordion-set:first-child > a").parent().addClass("active");
        }
 

    };
  
     /**
     * Do all necessary actions after Button is Click.
     *
     *
     * @returns {void}
     */
    var trackButtonClick = function trackButtonClick() {

        jQuery( planSelectors.planButton ).click(function(){
            var data = {
                action: 'plan_button',
                currentPlan: planType,
                planType: jQuery( this ).attr( planButtonAttr.planTypeAttr ),
                planMonthly: jQuery( this ).attr( planButtonAttr.planMonthlyAttr ),
                planAnnualAttr: jQuery( this ).attr( planButtonAttr.planAnnualAttr )
              };
            
            jQuery.get(
                ajax_url,
                data
             );
        })
    }

    var setButtonLinkAttribute = function setButtonLinkAttribute(planType) {
        
        jQuery( planSelectors.planButton ).each( function(){            
            var currentDataUrl = jQuery(this).attr( planButtonAttr.planUrlAttr );
            var currentUTMMonthly = jQuery(this).attr( planButtonAttr.utmPlanMonthlyAttr );
            var currentUTMAnnually = jQuery(this).attr( planButtonAttr.utmPlanAnnualAttr );
            // assign Annually UTM Params to url
            if( planType == planTypeConstant.annually && currentUTMAnnually != ''){
                jQuery(this).attr( 'href' , currentDataUrl + currentUTMAnnually )
            }
            // assign monthly UTM Params to url
            if( planType == planTypeConstant.monthly && currentUTMMonthly != ''){
                jQuery(this).attr( 'href' , currentDataUrl + currentUTMMonthly )
            }
        });         
    }




    var showLoader = function showLoader(){
        var $pricingGroup = jQuery('#v7-pricing-tabs-section');
        var $innerPricingElement = jQuery('#v7-pricing-tabs-section .v7-price-cards-wrapper');
        setTimeout(function () {
              $pricingGroup.addClass('loaded-content');
              $innerPricingElement.removeClass("v7-invisible-box");
          }, 400);
    }

    jQuery(document).ready(function() {
      showLoader();
      init();
      setButtonLinkAttribute(planType);
    });

  }());