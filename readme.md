# wordpress picture site

## setup

copy `.env.sample` to `.env` and add desired values.

## run

`docker-compose up`

website: http://localhost:80
phpmyadin: http://localhost:8080

## todo

- make home and category page work the same
- left menu / right content layout
- seed wordpress with credentials via docker-compose and .env file.. no registration/setup page
- uploads, don’t store in dated folders..
- sitemap
- nice theme
- add icon to gallery post type
- js includes

### design

- home and category pages should have thumbs from each gallery in content area with gallery name, like https://www.nikkla.com/
- list of galleries on left, with about page further down, similar to https://www.levonbiss.com/
- gallery page
    - columnar layout, image with caption beneath