<?php
use \Instapage\Classes\Factory;
use Instapage\Classes\Component;
use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Forms\FormResponse;

$model = Factory::getModel(getV5Page());
$response = $model->handleFormSubmit();
$menu = getV5Menu('v5-top-menu');

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header', ['headerClass' => 'v7-careers']);
Component::render('expandable-tiles', ['layout' => 'careers']);
Component::render('v51/carousel');
Component::render('filter');
Component::render('tiles', get_field('tile_layout') ?? 'default', ['isAnimated' => false]);
Component::render(
    'v51/workable',
    [
        'title' => __('Apply to one of our open positions'),
    ]
);
?>

<section class="v7 v7-content v7-mt-80">
    <div class="lg-tb-visible v7-mb-30 text-center">
        <h2 class="h1"><?= __('Ready to join us?'); ?></h2>
        <p><?= __('We’d love to hear from you'); ?></p>
    </div>
    <div class="img-section careers-form">
        <div class="img-right-wrapper">
            <?php Component::render('v51/image', ['onlyLazyImageClass' => true, 'class' => 'careers-form-image']); ?>
        </div>
        <div class="img-content">
            <div class="v7-ml-xl-100 division-header-left">
            <div class="lg-tb-hidden">
                <h2 class="h1"><?= __('Ready to join us?'); ?></h2>
                <p><?= __('We’d love to hear from you'); ?></p>
            </div>
            <?php
            Component::render(
                'form',
                'careers',
                [
                    'response' => $response,
                    'nonceTokenName' => $model->getNonceTokenName()
                ]
            ); ?>
            </div>
        </div>
    </div>
</section>

<section class="v7 v7-section-darker v7-mt-100 v7-py-80">
    <h2 class="h1 v7-mb-40 v7-mb-md-50 text-center"><?= __('Learn more about us') ?></h2>
    <div class="panel-rounded-wrapper">
        <a href="https://linkedin.com/company/instapage" target="_blank" class="panel-rounded panel-rounded-social">
            <svg
                class="panel-rounded-social-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="29"
                viewBox="0 0 30 29"
            >
                <path fill="#BACEE4" fill-rule="evenodd" d="M30 17.69v11.148h-6.432V18.424c0-2.611-.927-4.394-3.254-4.394a3.526 3.526 0 0 0-3.299 2.366 4.497 4.497 0 0 0-.22 1.578v10.864h-6.426s.086-17.625 0-19.447h6.428v2.753a.49.49 0 0 0-.037.071h.037v-.07a6.377 6.377 0 0 1 5.796-3.212C26.832 8.933 30 11.71 30 17.69zM3.64.01a3.373 3.373 0 1 0-.082 6.73h.039A3.373 3.373 0 1 0 3.64.01zM.388 28.839h6.427V9.39H.387v19.447z"/>
            </svg>
            <span class="panel-rounded-tooltip md-visible">LinkedIn</span>
        </a>
        <a href="https://www.facebook.com/Instapageapp" target="_blank" class="panel-rounded panel-rounded-social">
            <svg
                class="panel-rounded-social-icon"
                class="panel-rounded-i"
                xmlns="http://www.w3.org/2000/svg"
                width="17"
                height="30"
                viewBox="0 0 17 30"
            >
                <path fill="#BACEE4" fill-rule="evenodd" d="M15.531.008L11.66 0C7.311 0 4.5 2.897 4.5 7.388v3.401H.61a.613.613 0 0 0-.61.616v4.933a.612.612 0 0 0 .61.608H4.5v12.446A.605.605 0 0 0 5.11 30h5.077a.606.606 0 0 0 .61-.608V16.946h4.55a.61.61 0 0 0 .609-.608v-4.933a.605.605 0 0 0-.178-.434.594.594 0 0 0-.431-.182h-4.552V7.901c0-1.382.33-2.092 2.127-2.092h2.605a.605.605 0 0 0 .608-.608V.624a.612.612 0 0 0-.603-.616z"/>
            </svg>
            <span class="panel-rounded-tooltip md-visible">Facebook</span>
        </a>
        <a href="https://www.instagram.com/instapage.team/" target="_blank" class="panel-rounded panel-rounded-social">
            <svg
                class="panel-rounded-social-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="30"
                viewBox="0 0 30 30"
            >
                <path fill="#BACEE4" fill-rule="evenodd" d="M21.72 0H8.278A8.29 8.29 0 0 0 0 8.282v13.436A8.29 8.29 0 0 0 8.278 30H21.72a8.29 8.29 0 0 0 8.278-8.282V8.282A8.29 8.29 0 0 0 21.72 0zm5.617 21.718a5.623 5.623 0 0 1-5.617 5.621H8.278a5.623 5.623 0 0 1-5.617-5.62V8.281A5.623 5.623 0 0 1 8.278 2.66H21.72a5.623 5.623 0 0 1 5.617 5.62v13.437zM15 7.271A7.729 7.729 0 1 0 22.73 15a7.737 7.737 0 0 0-7.73-7.729zm0 12.797a5.068 5.068 0 1 1 0-10.136 5.068 5.068 0 0 1 0 10.136zm8.053-15.055a1.946 1.946 0 1 0 .01 3.892 1.946 1.946 0 0 0-.01-3.892z"/>
            </svg>
            <span class="panel-rounded-tooltip md-visible">Instagram</span>
        </a>
        <a href="https://twitter.com/instapage" target="_blank" class="panel-rounded panel-rounded-social">
            <svg
                class="panel-rounded-social-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="25"
                viewBox="0 0 30 25"
            >
                <path fill="#BACEE4" fill-rule="evenodd" d="M29.17.45a12.604 12.604 0 0 1-3.908 1.5 6.153 6.153 0 0 0-10.647 4.216c-.001.473.052.944.158 1.405A17.456 17.456 0 0 1 2.09 1.129a6.186 6.186 0 0 0 1.905 8.234 6.166 6.166 0 0 1-2.787-.774v.08a6.173 6.173 0 0 0 4.935 6.046 6.09 6.09 0 0 1-1.62.221 6.231 6.231 0 0 1-1.16-.118 6.158 6.158 0 0 0 5.747 4.287 12.308 12.308 0 0 1-7.642 2.644c-.49 0-.98-.03-1.468-.086a17.368 17.368 0 0 0 9.433 2.77c11.32 0 17.509-9.402 17.509-17.557l-.02-.797c1.209-.87 2.252-1.95 3.078-3.19a12.36 12.36 0 0 1-3.534.971A6.203 6.203 0 0 0 29.17.45z"/>
            </svg>
            <span class="panel-rounded-tooltip md-visible">Twitter</span>
        </a>
        <a href="https://www.youtube.com/Instapage" target="_blank" class="panel-rounded panel-rounded-social">
            <svg
                class="panel-rounded-social-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="21"
                viewBox="0 0 30 21"
            >
                <path fill="#BACEE4" fill-rule="evenodd" d="M28.729 1.997C27.916.545 27.032.277 25.232.174 23.432.047 18.916 0 15 0 11.085 0 6.561.047 4.77.174c-1.793.102-2.677.363-3.5 1.823C.431 3.45 0 5.952 0 10.35v.016c0 4.389.432 6.907 1.27 8.344.823 1.453 1.707 1.713 3.5 1.84 1.791.102 6.315.165 10.23.165 3.916 0 8.432-.063 10.232-.166 1.8-.126 2.684-.386 3.497-1.839.845-1.437 1.271-3.955 1.271-8.344v-.008c0-4.406-.426-6.908-1.271-8.36zM11.25 16.01V4.705l9.38 5.653-9.38 5.652z"/>
            </svg>
            <span class="panel-rounded-tooltip md-visible">YouTube</span>
        </a>
        <a href="<?= get_home_url() . '/blog' ?>" target="_blank" class="panel-rounded panel-rounded-social">
            <svg
                class="panel-rounded-social-icon"
                width="36px"
                height="36px"
                viewBox="0 0 36 36"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
            >
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Artboard" transform="translate(-858.000000, -357.000000)" fill="#BACEE4" fill-rule="nonzero">
                    <g id="Group" transform="translate(858.000000, 357.000000)">
                    <path d="M12.1320634,11.9005856 C11.0582123,11.8574699 10.2226362,10.9519894 10.2657519,9.87813836 C10.3088677,8.8042873 11.2143481,7.96871122 12.2881992,8.01182695 C20.7081202,8.34989153 27.3757382,15.2820207 27.3757382,23.7389953 C27.3757382,24.8137115 26.5045085,25.6849412 25.4297923,25.6849412 C24.355076,25.6849412 23.4838463,24.8137115 23.4838463,23.7389953 C23.4838463,17.3717734 18.4660328,12.1548981 12.1320634,11.9005856 Z" id="Stroke-1"></path>
                    <path d="M14.905737,4.57125332 C13.8313198,4.54590092 12.9808847,3.65436151 13.0062371,2.57994431 C13.0315895,1.50552711 13.9231289,0.655092058 14.9975461,0.680444458 C26.2859962,0.946811464 35.3146431,10.1761368 35.3146431,21.4952532 C35.3146431,22.5699695 34.4434134,23.4411992 33.3686972,23.4411992 C32.2939809,23.4411992 31.4227512,22.5699695 31.4227512,21.4952532 C31.4227512,12.2911917 24.0825022,4.78779212 14.905737,4.57125332 Z" id="Stroke-3"></path>
                    <path d="M0.000300231658,9.34045811 C0.000300231658,8.26574184 0.871529908,7.39451217 1.94624618,7.39451217 C3.02096245,7.39451217 3.89219212,8.26574184 3.89219212,9.34045811 L3.89219212,26.5306332 C3.89219212,29.3247803 6.15591307,31.5887073 8.94934312,31.5887073 C11.7430286,31.5887073 14.0074173,29.3245248 14.0074173,26.5306332 C14.0074173,23.7381263 11.742567,21.4734822 8.94934312,21.4734822 C7.87462685,21.4734822 7.00339717,20.6022525 7.00339717,19.5275362 C7.00339717,18.45282 7.87462685,17.5815903 8.94934312,17.5815903 C13.8919202,17.5815903 17.8993092,21.5886144 17.8993092,26.5306332 C17.8993092,31.4740367 13.8923818,35.4805992 8.94934312,35.4805992 C4.0064012,35.4805992 0.000300231658,31.4741335 0.000300231658,26.5306332 L0.000300231658,9.34045811 Z" id="Stroke-5"></path>
                    </g>
                </g>
                </g>
            </svg>
            <span class="panel-rounded-tooltip md-visible">Blog</span>
        </a>
    </div>
</section>

<?php
Component::render('v51/footer');
Component::render('v51/document-end');
