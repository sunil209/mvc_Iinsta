<?= '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?= '<?xml-stylesheet type="text/xsl" href="//' . $_SERVER['DESIRED_DOMAIN'] . '/main-sitemap.xsl"?>'; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php foreach ($data as $row): ?>
    <url>
      <?php foreach ($row as $key => $value): ?>
        <?= sprintf('<%1$s>%2$s</%1$s>', $key, $value); ?>
      <?php endforeach; ?>
    </url>
  <?php endforeach; ?>
</urlset>
