# wordpress picture site

## setup

copy `.env.sample` to `.env` and add desired values.

## run

`docker-compose up`

visit http://localhost/wp-admin/install.php to complete the installation of wordpress (seeding db tables)

website: http://localhost:80
phpmyadin: http://localhost:8080 (user: root, password: [from .env])


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
