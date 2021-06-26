<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://instapage.com/wp-content/themes/instapagev3/v5/assets/css/topfold51.min.css">
    <link rel="stylesheet" type="text/css" href="https://instapage.com/wp-content/themes/instapagev3/v5/assets/css/styles51.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.11.0/themes/prism.css">
    <style type="text/css">
      body {
        padding: 50px 0;
      }

      /* TABLE (since we don't have it in v5.1 yet) */
      table {
        width: 100%;
        text-align: left;
      }

      table thead tr {
        border-bottom: 1px solid #bcced6;
        padding: 20px 0;
      }

      table td,
      table th {
        padding: 10px;
      }

      /* Specific component for docs template. Used for spacing mostly. */
      .doc {
        margin-top: 100px;
      }

      .doc-variant {
        margin-top: 10px;
      }

      .doc-header {
        border-bottom: 2px solid #bcced6;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-end;
      }

      .doc-tech {
        margin-left: auto;
      }

      .doc-table {
        margin: 50px 0;
      }

      .doc-tech-icon {
        width: 32px;
        height: 32px;
      }

      .doc-usage {
        margin-top: 50px;
      }

      .doc-run {
        margin-top: 10px;
      }

      .doc-links {
        margin-top: 50px;
      }

      /* PRISM CUSTOM STYLING */
      :not(pre) > code[class*="language-"],
      pre[class*="language-"] {
        background: #0D1A2B;
      }

      code[class*="language-"],
      pre[class*="language-"] {
        color: #F2F7F9;
        text-shadow: none;
        font-weight: bold;
      }

      .token.selector,
      .token.attr-name,
      .token.string,
      .token.char,
      .token.builtin,
      .token.inserted {
        color: #66d9ef;
      }

      .token.operator,
      .token.entity,
      .token.url,
      .language-css .token.string,
      .style .token.string {
        background: none;
        color: orange;
      }
    </style>
    <script src="https://instapage.com/wp-content/themes/instapagev3/v5/assets/js/v51/scripts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/combine/npm/prismjs@1.11.0,npm/prismjs@1.11.0/components/prism-css.min.js,npm/prismjs@1.11.0/components/prism-php.min.js,npm/prismjs@1.11.0/components/prism-javascript.min.js"></script>
    <title><?= $component->getName(); ?> | <?= $this->title; ?></title>
  </head>
  <body>
    <main>
      <header class="content">
        <h1><?= $component->getName(); ?> | <?= $this->title; ?></h1>
      </header>
      <section class="doc">
        <header class="doc-header content">
          <div>
            <h2><?= $component->getName(); ?></h2>
            <small><?= substr($component->getPath(), strlen(COMPDOC_ROOT)); ?></small><br>
          </div>
          <div class="doc-tech">
            <?php if ($component->has('styles')): ?>
              <svg class="doc-tech-icon" viewBox="0 0 128 128">
                <path fill="#1572B6" d="M19.67 26l8.069 90.493 36.206 10.05 36.307-10.063 8.078-90.48h-88.66zm69.21 50.488l-2.35 21.892.009 1.875-22.539 6.295v.001l-.018.015-22.719-6.225-1.537-17.341h11.141l.79 8.766 12.347 3.295-.004.015v-.032l12.394-3.495 1.308-14.549h-25.907000000000004l-.222-2.355-.506-5.647-.265-2.998h27.886000000000003l1.014-11h-42.473l-.223-2.589-.506-6.03-.265-3.381h55.597l-.267 3.334-2.685 30.154"></path><path fill="#1572B6" d="M89 14.374l-7.149-8.374h7.149v-5h-16v4.363l8.39 7.637h-8.39v5h16zM70 14.374l-6.807-8.374h6.807v-5h-15v4.363l7.733 7.637h-7.733v5h15zM52 13h-8v-7h8v-5h-14v17h14z"></path>
              </svg>
            <?php endif; ?>
            <?php if ($component->has('scripts')): ?>
              <svg class="doc-tech-icon" viewBox="0 0 128 128">
                <path fill="#F0DB4F" d="M2 1v125h125v-125h-125zm66.119 106.513c-1.845 3.749-5.367 6.212-9.448 7.401-6.271 1.44-12.269.619-16.731-2.059-2.986-1.832-5.318-4.652-6.901-7.901l9.52-5.83c.083.035.333.487.667 1.071 1.214 2.034 2.261 3.474 4.319 4.485 2.022.69 6.461 1.131 8.175-2.427 1.047-1.81.714-7.628.714-14.065-.001-10.115.046-20.188.046-30.188h11.709c0 11 .06 21.418 0 32.152.025 6.58.596 12.446-2.07 17.361zm48.574-3.308c-4.07 13.922-26.762 14.374-35.83 5.176-1.916-2.165-3.117-3.296-4.26-5.795 4.819-2.772 4.819-2.772 9.508-5.485 2.547 3.915 4.902 6.068 9.139 6.949 5.748.702 11.531-1.273 10.234-7.378-1.333-4.986-11.77-6.199-18.873-11.531-7.211-4.843-8.901-16.611-2.975-23.335 1.975-2.487 5.343-4.343 8.877-5.235l3.688-.477c7.081-.143 11.507 1.727 14.756 5.355.904.916 1.642 1.904 3.022 4.045-3.772 2.404-3.76 2.381-9.163 5.879-1.154-2.486-3.069-4.046-5.093-4.724-3.142-.952-7.104.083-7.926 3.403-.285 1.023-.226 1.975.227 3.665 1.273 2.903 5.545 4.165 9.377 5.926 11.031 4.474 14.756 9.271 15.672 14.981.882 4.916-.213 8.105-.38 8.581z"></path>
              </svg>
            <?php endif; ?>
            <?php if ($component->has('logic')): ?>
              <svg class="doc-tech-icon" viewBox="0 0 128 128">
                <path fill="#6181B6" d="M64 33.039c-33.74 0-61.094 13.862-61.094 30.961s27.354 30.961 61.094 30.961 61.094-13.862 61.094-30.961-27.354-30.961-61.094-30.961zm-15.897 36.993c-1.458 1.364-3.077 1.927-4.86 2.507-1.783.581-4.052.461-6.811.461h-6.253l-1.733 10h-7.301l6.515-34h14.04c4.224 0 7.305 1.215 9.242 3.432 1.937 2.217 2.519 5.364 1.747 9.337-.319 1.637-.856 3.159-1.614 4.515-.759 1.357-1.75 2.624-2.972 3.748zm21.311 2.968l2.881-14.42c.328-1.688.208-2.942-.361-3.555-.57-.614-1.782-1.025-3.635-1.025h-5.79l-3.731 19h-7.244l6.515-33h7.244l-1.732 9h6.453c4.061 0 6.861.815 8.402 2.231s2.003 3.356 1.387 6.528l-3.031 15.241h-7.358zm40.259-11.178c-.318 1.637-.856 3.133-1.613 4.488-.758 1.357-1.748 2.598-2.971 3.722-1.458 1.364-3.078 1.927-4.86 2.507-1.782.581-4.053.461-6.812.461h-6.253l-1.732 10h-7.301l6.514-34h14.041c4.224 0 7.305 1.215 9.241 3.432 1.935 2.217 2.518 5.418 1.746 9.39zM95.919 54h-5.001l-2.727 14h4.442c2.942 0 5.136-.29 6.576-1.4 1.442-1.108 2.413-2.828 2.918-5.421.484-2.491.264-4.434-.66-5.458-.925-1.024-2.774-1.721-5.548-1.721zM38.934 54h-5.002l-2.727 14h4.441c2.943 0 5.136-.29 6.577-1.4 1.441-1.108 2.413-2.828 2.917-5.421.484-2.491.264-4.434-.66-5.458s-2.772-1.721-5.546-1.721z"></path>
              </svg>
            <?php endif; ?>
          </div>
        </header>
        <div class="content">
          <h3>Variations</h3>
          <?php foreach ($component->getVariants() as $variant): ?>
            <h4 class="doc-variant"><?= $variant->getName(); ?></h4>
            <?php if (isset($variant->getTags()['description'])): ?>
            <h5><?= $variant->getTags()['description'][0]['Description']; ?></h5>
            <?php endif; ?>
            <small><?= substr($variant->getPath(), strlen(COMPDOC_ROOT)); ?></small><br>
            <div class="doc-table">
              <?php if (isset($variant->getTags()['param'])): ?>
                <h5>Parameters</h5>
                <table>
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Name</th>
                      <th colspan="2">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($variant->getTags()['param'] as $param): ?>
                      <tr>
                        <td><i><?= str_replace('|', ' | ', $param['Type']); ?></i></td>
                        <td><?= $param['Name']; ?></td>
                        <td colspan="2"><?= htmlspecialchars($param['Description']); ?></td>
                      </tr>
                      <?php if (isset($param['SubParams']) && !empty($param['SubParams'])): ?>
                        <thead>
                          <tr>
                            <th></th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <?php foreach ($param['SubParams'] as $subParam): ?>
                          <tr>
                            <td></td>
                            <td><i><?= str_replace('|', ' | ', $subParam['Type']); ?></i></td>
                            <td><?= $subParam['Name']; ?></td>
                            <td><?= htmlspecialchars($subParam['Description']); ?></td>
                          </tr>
                        <?php endforeach; ?>
                        <thead>
                          <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th colspan="2">Description</th>
                          </tr>
                        </thead>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
            <?php if (isset($variant->getTags()['example'])): ?>
              <div class="doc-usage">
                <?php foreach ($variant->getTags()['example'] as $example): ?>
                  <h5><?= $example['Name']; ?></h5>
                  <pre><code class="language-php"><?= $example['Code']; ?></code></pre>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <?php if (isset($variant->getTags()['link'])): ?>
              <div class="doc-links">
                <h5>Links</h5>
                <ul>
                  <?php foreach ($variant->getTags()['link'] as $link): ?>
                    <li><a href="<?= $link['Url']; ?>" target="_blank" rel="noopener noreferer"><?= $link['Url']; ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </body>
</html>
