var multistepForm = (function() {
    var config = {
        selectors: {
            multistepFieldset: '.js-form-fieldset',
            multistepBtn: '.js-multistep-btn',
            multiStepForm: '.js-multistep-form',
            field: '.js-v7-input-field',
            btnWithLoadingStateWrapper: '.js-btn-with-loading-state-wrapper'
        },
        hiddenClass: 'is-invisible',
        fadeInClass:'v7-fade-in',
        fadeOutClass: 'v7-fade-out',
    };
    var index = 0;
    var sendEventsFlags = {};

    function validateVisibleFieldsAndMoveToNextStep() {
        var $fields = jQuery(config.multistepFieldsetElements[index].querySelectorAll(config.selectors.field));
        var isValid = InstapageValidation.prototype.validateFields($fields);
        if (isValid && index < config.multistepFieldsetElements.length) {
            config.multistepFieldsetElements[index].classList.add(config.fadeOutClass, config.hiddenClass);
            index++;
            emitStepCompletitionEvent(index);
            config.multistepFieldsetElements[index].classList.remove(config.fadeOutClass, config.hiddenClass);
            config.multistepFieldsetElements[index].classList.add(config.fadeInClass);
        }
    }

    function emitStepCompletitionEvent(stepNumber) {
        // assure that event for this stepnumber is send only once
        if (sendEventsFlags[stepNumber]) {
            return;
        }
        sendEventsFlags[stepNumber] = true;

        var stepCompletitionEvent = new CustomEvent('multistepform:stepcompletition', {detail: {
            stepNumber: stepNumber,
            formName: getFormName(),
            formElement: config.formElement,
        }});

        document.dispatchEvent(stepCompletitionEvent);
    }

    function getFormName() {
        return config.formElement.dataset.multistepFormName;
    }

    function handleLastStepCompletionEvent() {
        config.formElement.addEventListener('form:validationsucessfull', function() {
            triggerSubmitButtonLoadingState();
            emitStepCompletitionEvent(config.multistepFieldsetElements.length);
        });
    }

    function triggerSubmitButtonLoadingState() {
        config.btnWithLoadingStateWrapperElement.classList.add('is-loading');
    }

    var init = function init() {
        if (document.querySelectorAll(config.selectors.multistepFieldset).length) {
            config.multistepFieldsetElements = document.querySelectorAll(config.selectors.multistepFieldset);
            config.multistepBtnElements = document.querySelectorAll(config.selectors.multistepBtn);
            config.formElement = document.querySelector(config.selectors.multiStepForm);
            config.btnWithLoadingStateWrapperElement = document.querySelector(config.selectors.btnWithLoadingStateWrapper);

            handleLastStepCompletionEvent();

            config.multistepBtnElements.forEach(function(btn) {
                btn.addEventListener('click', validateVisibleFieldsAndMoveToNextStep);
            });
        }
    };

    return {
        init: init,
    };
})();

window.addEventListener('load', multistepForm.init);
