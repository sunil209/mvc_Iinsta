<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $response        Form state
 * @param string $nonceTokenName  Nonce token name
 *
 * @example Usage
 * Component::render(
 *   'form',
 *   'multistep,
 *   [
 *     'response' => $response,
 *     'nonceTokenName' => $model->getNonceTokenName()
 *   ]
 * );
 * @endexample
 */

use \Instapage\Classes\Component;
?>
<div class="v7 container <?= $class; ?>">
    <?php if (isset($class) && $class == 'v7-insta-loader') { echo '<div class="insta-loader insta-white-loader"></div>'; } ?>
    <div class="row">
        <div class="v7-mb-60 col-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2 <?php if (isset($class) && $class== 'v7-insta-loader') { echo 'v7-loader-content v7-invisible-content';} ?>">
            <div class="v7-hs-form">
                <script>
                    function LoadZoomInfo(){
                            window._zi = {formId: 'wADAOQdEWFlS0RJ8xs78'};
                            var zi = document.createElement('script');
                                zi.type = 'text/javascript';
                                zi.async = true;
                                zi.src = 'https://ws-assets.zoominfo.com/formcomplete.js';
                                var s = document.getElementsByTagName('script')[0];
                                s.parentNode.insertBefore(zi, s);
                        }

                        setTimeout(function(){ 
                            LoadZoomInfo();
                        }, 3000)
                </script>
                <script src="https://js.chilipiper.com/marketing.js" type="text/javascript"></script>
                <!--[if lte IE 8]>
                <script charset="utf-8" type="text/javascript" src="https://js.hsforms.net/forms/v2-legacy.js"></script>
                <![endif]-->
                <script charset="utf-8" type="text/javascript" src="https://js.hsforms.net/forms/v2.js"></script>
                <script>
                    hbspt.forms.create({
                    region: "na1",
                    portalId: '7533492',
                    formId: 'c31e8ad1-1d40-42c4-af2e-2ef0225a5c24',
                    translations: {
                                en: {
                                    forbiddenEmailDomain : "Please enter your business email.",
                                    phoneInvalidRangeTooShort: "Please enter at least 7 digits.",
                                    phoneInvalidRangeTooLong: "Please enter  at most 20 digits only."
                                }
                            },
                            onFormSubmit: function($form) {

                                if(ga){
                                    ga('send', 'event', 'Multistep form', 'Submitted Successfully', 'Enteprise demo request');
                                }
                                

                                var data = {}
                                $form.serializeArray().forEach(function(el) {
                                    data[el.name] = el.value
                                })
                                ChiliPiper.submit('postclick', 'instapage-demo-router', {
                                    title: 'Thanks! What time works best for a quick call?',
                                    map: true,
                                    lead: {
                                            FirstName: data.firstname,
                                            LastName: data.lastname,
                                            Email: data.email,
                                            Company: data.company,
                                            Phone: data.phone,
                                            State: data.company_state,
                                            Country: data.company_country,
                                            City: data.company_city, 
                                            Size: data.company_size
                                        },
                                    })

                            },
                    })
                </script>

                <p class="v7-mt-20 v7-mt-md-30 v7-heading-small text-center">
                    <?= __('Looking for support?') ?>
                    <a class="v7-btn-flat v7-text-underlined" href="<?= URL_INSTAPAGE_HELP ?>" target="_blank">
                        <?= __('Contact us here') ?>
                    </a>
                </p>

            </div>


        </div>
    </div>
</div>