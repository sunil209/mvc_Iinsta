<?php
use Instapage\Classes\Component;

Component::render(
  'amp/document-start',
  [
    'components' => [
      'analytics' => true,
      'form' => true
    ],
    'cssFile' => 'amp/landing-page.css'
  ]
);

Component::render(
  'amp/header',
  [
    'components' => [
      'analytics' => true
    ],
    'navigation' => false
  ]
); ?>
<header class="main-header">
  <div class="content">
    <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="171" height="35" viewBox="0 0 171 35">
      <path d="M171 20.6C171 20.9 170.8 21.1 170.5 21.1L158.8 21.1C158.9 24 161 25.8 163.8 25.8 165.9 25.8 167.2 24.8 168 24 168.2 23.8 168.5 23.7 168.7 23.9L170.1 24.9C170.3 25.1 170.4 25.4 170.2 25.6 169.3 27 167.2 28.7 163.8 28.7 158.7 28.7 155.4 25.2 155.4 20.4 155.4 15.5 158.8 12 163.2 12 168.1 12 171 15.3 171 20.3 171 20.4 171 20.5 171 20.6ZM163.3 14.8C161 14.8 159.2 16.3 159 18.8L167.6 18.8C167.4 16.2 165.6 14.8 163.3 14.8ZM144.7 34.9C142.7 34.9 140.7 34.3 139.3 33.6 139 33.5 138.9 33.2 139 33L139.7 31.3C139.8 31.1 140.1 30.9 140.4 31.1 141.2 31.5 142.8 32 144.6 32 147.3 32 149.7 30.3 149.7 27.3L149.7 26.2C149.3 26.7 147.7 28.7 144.5 28.7 139.9 28.7 136.8 25.3 136.8 20.4 136.8 15.5 140 12 144.6 12 147.6 12 149.4 13.8 149.9 14.5L149.9 13C149.9 12.7 150.2 12.4 150.5 12.5L152.6 13C152.9 13 153 13.2 153 13.5L153 26.2C153 32.2 149.4 34.9 144.7 34.9ZM145 14.9C142.2 14.9 140.2 17.1 140.2 20.3 140.2 23.6 142.3 25.7 145 25.7 147.9 25.7 149.8 23.5 149.8 20.3 149.8 17.1 147.8 14.9 145 14.9ZM133.5 28.3L131.5 28.3C131.3 28.3 131.1 28.1 131 27.9L130.8 27.1C130 28 128.7 28.7 126.7 28.7 123.3 28.7 120.6 26.6 120.6 23.4 120.6 20.3 123.2 18.1 126.9 18.1 128.7 18.1 130.1 18.8 130.7 19.3L130.7 17.8C130.7 16 129.4 14.9 127.3 14.9 125.7 14.9 124.3 15.3 123.2 15.9 123 16 122.7 15.9 122.5 15.7L121.7 14.2C121.6 14 121.7 13.7 121.9 13.5 123.2 12.8 125.2 12 127.6 12 132.4 12 134.1 14.5 134.1 18L134.1 27.8C134.1 28.1 133.8 28.3 133.5 28.3ZM127.4 20.6C125.3 20.6 124 21.7 124 23.3 124 24.9 125.4 26 127.4 26 129.4 26 130.8 24.9 130.8 23.3 130.8 21.6 129.4 20.6 127.4 20.6ZM110.9 28.7C107.9 28.7 106.1 26.9 105.7 26.2L105.7 34.4C105.7 34.7 105.5 34.9 105.2 34.9L102.9 34.9C102.6 34.9 102.3 34.7 102.3 34.4L102.3 13C102.3 12.7 102.7 12.4 103 12.5L105.1 13C105.4 13 105.5 13.2 105.5 13.5L105.5 14.5C106 13.9 107.6 12 110.7 12 115.3 12 118.6 15.5 118.6 20.3 118.6 25.3 115.5 28.7 110.9 28.7ZM110.4 14.9C107.4 14.9 105.6 17.4 105.6 20.3 105.6 23.8 107.7 25.7 110.4 25.7 113.2 25.7 115.2 23.5 115.2 20.3 115.2 17 113.1 14.9 110.4 14.9ZM98.6 28.3L96.6 28.3C96.4 28.3 96.1 28.1 96.1 27.9L95.9 27.1C95.1 28 93.8 28.7 91.8 28.7 88.4 28.7 85.7 26.6 85.7 23.4 85.7 20.3 88.2 18.1 91.9 18.1 93.8 18.1 95.2 18.8 95.8 19.3L95.8 17.8C95.8 16 94.5 14.9 92.4 14.9 90.8 14.9 89.4 15.3 88.3 15.9 88 16 87.7 15.9 87.6 15.7L86.8 14.2C86.7 14 86.7 13.7 87 13.5 88.3 12.8 90.3 12 92.7 12 97.5 12 99.1 14.5 99.1 18L99.1 27.8C99.1 28.1 98.9 28.3 98.6 28.3ZM92.4 20.6C90.4 20.6 89 21.7 89 23.3 89 24.9 90.4 26 92.5 26 94.5 26 95.9 24.9 95.9 23.3 95.9 21.6 94.5 20.6 92.4 20.6ZM82.1 28.5C78.2 28.5 77 25.9 77 22L77 15.1 75.8 15.1C75.5 15.1 75.3 14.9 75.3 14.6L75.3 12.9C75.3 12.6 75.5 12.4 75.8 12.4L77 12.4 77 9.7C77 9.4 77.4 9.1 77.7 9.2L80 9.6C80.2 9.7 80.4 9.9 80.4 10.1L80.4 12.4 83.1 12.4C83.4 12.4 83.7 12.6 83.7 12.9L83.7 14.6C83.7 14.9 83.4 15.1 83.1 15.1L80.4 15.1 80.4 22.5C80.4 25 81.3 25.6 83.1 25.6 83.2 25.6 83.3 25.6 83.4 25.6 83.8 25.6 83.8 26 83.8 26L83.8 27.9C83.8 28.2 83.6 28.4 83.3 28.5 83 28.5 82.6 28.5 82.1 28.5ZM68.1 28.7C65.1 28.7 63.4 27.3 62.5 25.9 62.4 25.7 62.4 25.4 62.6 25.2L63.9 24.2C64.2 24 64.5 24.1 64.7 24.3 65.4 25.2 66.5 26 68.2 26 69.6 26 70.7 25.3 70.7 24 70.7 20.9 62.8 22 62.8 16.5 62.8 13.7 65.3 12 68.4 12 71.1 12 72.6 13.3 73.4 14.5 73.5 14.7 73.5 15.1 73.2 15.2L71.7 16.2C71.5 16.3 71.2 16.3 71 16.1 70.5 15.4 69.7 14.7 68.2 14.7 67 14.7 66 15.3 66 16.4 66 19.5 73.9 18.2 73.9 23.8 73.9 26.8 71.4 28.7 68.1 28.7ZM59.6 28.3L57.3 28.3C57 28.3 56.7 28.1 56.7 27.8L56.7 18.4C56.7 16.2 55.4 15 53.5 15 51.4 15 50 16.5 50 18.7L50 27.8C50 28.1 49.7 28.3 49.5 28.3L47.1 28.3C46.9 28.3 46.6 28.1 46.6 27.8L46.6 12.9C46.6 12.6 46.9 12.4 47.1 12.4L49.4 12.4C49.7 12.4 49.9 12.6 49.9 12.9L49.9 14.4C50.6 13.2 52.3 12 54.5 12 58.6 12 60.1 15.2 60.1 18.7L60.1 27.8C60.1 28.1 59.8 28.3 59.6 28.3ZM42.2 28.3L39.9 28.3C39.6 28.3 39.3 28.1 39.3 27.8L39.3 6.6C39.3 6.2 39.6 6 40 6L42.3 6.5C42.6 6.6 42.8 6.8 42.8 7L42.8 27.8C42.8 28.1 42.5 28.3 42.2 28.3ZM10.5 35C10.2 35 9.9 34.8 9.9 34.5L9.9 0.5C9.9 0.2 10.2 0 10.5 0L32.4 3.5C32.6 3.6 32.8 3.8 32.8 4.1L32.8 30.7C32.8 30.9 32.6 31.1 32.4 31.2L10.5 35ZM30 6.8C30 6.6 29.8 6.4 29.6 6.3L14.2 4.4C13.8 4.4 13.6 4.6 13.6 4.9L13.6 30.4C13.6 30.7 13.8 31 14.2 30.9L29.6 28.7C29.9 28.7 30 28.5 30 28.2L30 6.8ZM5.6 32.1C5.2 32.2 5 31.9 5 31.6L5 3.1C5 2.8 5.2 2.5 5.6 2.6L7.3 2.8C7.5 2.8 7.7 3.1 7.7 3.3L7.7 31.4C7.7 31.6 7.5 31.8 7.2 31.9L5.6 32.1ZM0.6 29.4C0.3 29.5 0 29.2 0 28.9L0 5.7C0 5.3 0.3 5.1 0.6 5.1L2.3 5.3C2.5 5.3 2.8 5.6 2.8 5.8L2.8 28.7C2.8 29 2.5 29.2 2.3 29.2L0.6 29.4Z" class="cls-1"></path>
    </svg>
  </div>
</header>
<main class="content">
  <div class="left-column">
    <h1><?= __('The AdWords Post-Click Optimization Guide'); ?></h1>
    <p><?= __('Increase AdWords conversions for your clients'); ?></p>
    <p class="list-title"><?= __('Here\'s some of what you\'ll learn:'); ?></p>
    <ul>
      <li><?= __('The most common mistake AdWords advertisers make'); ?></li>
      <li><?= __('Best practices for AdWords landing pages'); ?></li>
      <li><?= __('Why personalized ads maximize clicks'); ?></li>
      <li><?= __('The importance of tracking AdWords leads through the entire funnel'); ?></li>
    </ul>
  </div>
  <form method="post" action-xhr="/wp-admin/admin-ajax.php" target="_top" class="form">
    <input type="hidden" name="action" value="amp_landing_page_xhr">
    <input type="hidden" name="original_action" value="https://app.instapage.com/ajax/pageserver/email/7478956">
    <input type="hidden" name="<?= base64_encode('amp-experiment'); ?>" value="true">
    <div class="form-field">
      <input class="form-field-input" type="text" name="Rmlyc3QgTmFtZSAq" id="56dd8ed7d156e4837ee8937960202dba-0" required>
      <label class="form-field-label" for="56dd8ed7d156e4837ee8937960202dba-0"><?= __('First Name *'); ?></label>
      <div class="form-field-bar"></div>
      <div class="form-field-info">
        <span>Please enter your first name</span>
        <i class="material-icons">warning</i>
      </div>
    </div>
    <div class="form-field">
      <input class="form-field-input" type="text" name="TGFzdCBOYW1lICo=" id="56dd8ed7d156e4837ee8937960202dba-1" required>
      <label class="form-field-label" for="56dd8ed7d156e4837ee8937960202dba-1"><?= __('Last Name *'); ?></label>
      <div class="form-field-bar"></div>
      <div class="form-field-info">
        <span>Please enter your last name</span>
        <i class="material-icons">warning</i>
      </div>
    </div>
    <div class="form-field">
      <input class="form-field-input" type="text" name="V29yayBFbWFpbCAq" id="56dd8ed7d156e4837ee8937960202dba-4" required>
      <label class="form-field-label" for="56dd8ed7d156e4837ee8937960202dba-4"><?= __('Work Email *'); ?></label>
      <div class="form-field-bar"></div>
      <div class="form-field-info">
        <span>Please enter your work email</span>
        <i class="material-icons">warning</i>
      </div>
    </div>
    <div class="form-field">
      <input class="form-field-input" type="text" name="VGl0bGUgKg==" id="56dd8ed7d156e4837ee8937960202dba-2" required>
      <label class="form-field-label" for="56dd8ed7d156e4837ee8937960202dba-2"><?= __('Title *'); ?></label>
      <div class="form-field-bar"></div>
      <div class="form-field-info">
        <span>Please enter your title</span>
        <i class="material-icons">warning</i>
      </div>
    </div>
    <div class="form-field">
      <input class="form-field-input" type="text" name="Q29tcGFueSAq" id="56dd8ed7d156e4837ee8937960202dba-3" required>
      <label class="form-field-label" for="56dd8ed7d156e4837ee8937960202dba-3"><?= __('Company *'); ?></label>
      <div class="form-field-bar"></div>
      <div class="form-field-info">
        <span>Please enter your company</span>
        <i class="material-icons">warning</i>
      </div>
    </div>
    <div class="form-field">
      <select class="form-field-input" name="TW9udGhseSBBZCBCdWRnZXQgKg==" id="56dd8ed7d156e4837ee8937960202dba-5" required>
        <option class="hidden" value="<?= __('Monthly Ad Budget'); ?>" disabled selected><?= __('Average Monthly Ad Spend *'); ?></option>
        <option value="< $1,000"><?= __('&lt; $1,000'); ?></option>
        <option value="$1,000 - $10,000"><?= __('$1,000 - $10,000'); ?></option>
        <option value="$10,001 - $25,000"><?= __('$10,001 - $25,000'); ?></option>
        <option value="$25,001 - $50,000"><?= __('$25,001 - $50,000'); ?></option>
        <option value="$50,000+"><?= __('$50,000+'); ?></option>
        <option value="I don't know"><?= __('I don\'t know'); ?></option>
      </select>
      <div class="form-field-bar"></div>
      <div class="form-field-info">
        <span>Please enter your monthly ad budget</span>
        <i class="material-icons">warning</i>
      </div>
    </div>
    <div class="btn-wrapper">
      <input type="submit" class="btn" value="<?= __('Get My Free Ebook'); ?>">
    </div>
    <input type="hidden" name="variant" value="A">
    <input type="hidden" name="cmVmZXJyZXI=" value="[mbsy]" id="56dd8ed7d156e4837ee8937960202dba-6">
    <input type="hidden" name="redirect" value="<?= get_home_url(null, '/adwords-ebook-thank-you'); ?>">
    <input type="hidden" name="autopilot-integration" value="eyJ0b2tlbiI6ImJmYWRlYTliZjFjMzk5ZDllMzIzNmUzNGNhYWRhZDQwIiwibGlzdCI6ImNvbnRhY3RsaXN0X0VFMUQ0NzgzLUIwQUUtNDcxRi05OTZDLUMxQjdEOTlGNzI4RiIsInRyaWdnZXJzIjpbXSwiZmllbGRtYXAiOlt7Imluc3RhcGFnZSI6IkZpcnN0IE5hbWUgKiIsImludGVncmF0aW9uIjoiRmlyc3ROYW1lIn0seyJpbnN0YXBhZ2UiOiJMYXN0IE5hbWUgKiIsImludGVncmF0aW9uIjoiTGFzdE5hbWUifSx7Imluc3RhcGFnZSI6IlRpdGxlICoiLCJpbnRlZ3JhdGlvbiI6IkNVU1RPTV9GSUVMRF9JUHN0cmluZy0tQ29udGFjdC0tVXMtLVByaWNpbmctLS0tLXRpdGxlIn0seyJpbnN0YXBhZ2UiOiJDb21wYW55ICoiLCJpbnRlZ3JhdGlvbiI6IkNvbXBhbnkifSx7Imluc3RhcGFnZSI6IldvcmsgRW1haWwgKiIsImludGVncmF0aW9uIjoiRW1haWwifSx7Imluc3RhcGFnZSI6Ik1vbnRobHkgQWQgQnVkZ2V0ICoiLCJpbnRlZ3JhdGlvbiI6IkNVU1RPTV9GSUVMRF9JUHN0cmluZy0tQWQtLUJ1ZGdldCJ9LHsiaW5zdGFwYWdlIjoicmVmZXJyZXIiLCJpbnRlZ3JhdGlvbiI6IkNVU1RPTV9GSUVMRF9JUHN0cmluZy0tTGVhZC0tU2lnbnVwLS1SZWZlcnJhbC0tVVJMIn1dLCJjdXN0b21fZmllbGRzIjpbXX0=">
    <input type="hidden" name="validation" value="Tzo4OiJzdGRDbGFzcyI6Mjp7czo2OiJmaWVsZHMiO2E6Njp7czoxMjoiRmlyc3QgTmFtZSAqIjtPOjg6InN0ZENsYXNzIjoxOntzOjg6InJlcXVpcmVkIjtiOjE7fXM6MTE6Ikxhc3QgTmFtZSAqIjtPOjg6InN0ZENsYXNzIjoxOntzOjg6InJlcXVpcmVkIjtiOjE7fXM6NzoiVGl0bGUgKiI7Tzo4OiJzdGRDbGFzcyI6MTp7czo4OiJyZXF1aXJlZCI7YjoxO31zOjk6IkNvbXBhbnkgKiI7Tzo4OiJzdGRDbGFzcyI6MTp7czo4OiJyZXF1aXJlZCI7YjoxO31zOjEyOiJXb3JrIEVtYWlsICoiO086ODoic3RkQ2xhc3MiOjE6e3M6ODoicmVxdWlyZWQiO2I6MTt9czoxOToiTW9udGhseSBBZCBCdWRnZXQgKiI7Tzo4OiJzdGRDbGFzcyI6MTp7czo4OiJyZXF1aXJlZCI7YjoxO319czo3OiJmb3JtX2lkIjtzOjMyOiI1NmRkOGVkN2QxNTZlNDgzN2VlODkzNzk2MDIwMmRiYSI7fQ==">
  </form>
</main>
