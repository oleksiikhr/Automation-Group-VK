# Automation Group VK (in development)
<p align="center">
  <a href="https://vk.com/eng_day">Group in VK |
  <a href="https://vk.com/alexeykhr">Author in VK</a>
</p>
<p>
  <a href="https://github.com/Alexeykhr/Automation-Group-VK/tree/v1.0">Version 1.0</a>
  - callback API, upload youtube playlists, custom templates
</p>

## Requirements:
1. PHP 7.2 or newer.
2. MySQL, SQLite or PostgreSQL.
3. Cron (optional).

## Getting started
1. git clone git://github.com/Alexeykhr/Automation-Group-VK.git
2. run composer install
3. copy .env.example to .env and configure
4. copy configs/tokens-example.php to configs/tokens.php and configure
5. Import database.sql to itself
6. Setup cron to file on every minute: /public/index.php

## Request params:
```
To protect the file from accidentally running the script (.env - APP_SECRET):
- secret

Filters for selecting the correct token (configs/tokens.php):
- t_site
- t_type
- t_access
```

*Example query:*
```
https://localhost/?t_site=vk&t_type=user&t_access=photo,video&secret=123456
```

## TODO
Types of posts:
- [ ] stories
- [ ] exam
- [ ] videos
- [x] words
- [x] photos
- [x] verbs
- [x] polls
- [x] learn

## License
MIT
