<?php
use \Instapage\Classes\Component;
?>

<section class="v7 v7-content v7-mt-80">
    <?php Component::dumbRender('division-header', ['title' => 'Subscribe']); ?>
    <div class="v7-mt-30 v7-mx-auto text-center v7-subscribe-btn-container">
        <a
            class="v7-btn fx-ripple-effect v7-subscribe-btn email" 
            target="_blank"
            href="https://instapage.com/podcast-subscribe-email"
        >
            <i class="material-icons v7-email-icon">email</i>
        </a>
        <a
            class="v7-btn fx-ripple-effect v7-subscribe-btn"
            target="_blank"
            href="https://itunes.apple.com/us/podcast/advertising-influencers/id1184030899"
        >
            <img class="v7-subscribe-icon v7-i-tunes" alt="i-tunes" src="<?= get_template_directory_uri(); ?>/v5/assets/images/i-tunes.svg">
        </a>
        <a
            class="v7-btn fx-ripple-effect v7-subscribe-btn"
            target="_blank"
            href="https://play.google.com/music/m/Isleuxd7pdn62wmezuphdv5fbtm?t=Advertising_Influencers"
        >
            <img class="v7-subscribe-icon v7-g-play" alt="g-play" src="<?= get_template_directory_uri(); ?>/v5/assets/images/google-play.svg">
        </a>
        <a
            class="v7-btn fx-ripple-effect v7-subscribe-btn"
            target="_blank"
            href="https://www.stitcher.com/podcast/instapage/advertising-influencers-conversations-with-marketing-thought"
        >
            <img class="v7-subscribe-icon" alt="sticher" src="<?= get_template_directory_uri(); ?>/v5/assets/images/stitcher.svg">
        </a>
    </div>
</section>
