# wordpress picture site

## setup

copy `.env.sample` to `.env` and add desired values.

## run

`docker-compose up`

To ensure the site can run on simple hosting (non-VPS where docker isn't option), you will need to fill db credentials into wp-config.php.

visit http://localhost/wp-admin/install.php to complete the installation of wordpress (seeding db tables)

Once installed and logged in, go to themes and activate 'picture-site' theme.

Next, add an 'About' page, and fill in some content about your site.

You can then start to create galleries, and categories, and add pictures to each gallery.

website: http://localhost:80
phpmyadin: http://localhost:8080 (user: root, password: [from .env])


### Optional

If you want to include custom js on each page, then duplicate and rename */www-workspace/wp-content/themes/picture-site/partials/custom-scripts-sample.php* to *custom-scripts.php*, then add scripts into that file which is added to every page before the closing body tag.


## to-do

- seed wordpress with credentials via docker-compose and .env file.. no registration/setup page
- sitemap
- js includes
- add a snailtrail under the title on gallery pages
- seo stuff
- analytics
- lightbox keyboard shortcuts - esc left right
- watermark images
- get date and exif info
