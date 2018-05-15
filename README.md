# Automation Group VK (in development)

<p align="center">
<a href="https://vk.com/eng_day">Link example</a> |
<a href="https://vk.com/alexeykhr">Issues</a>
</p>

## Installing
- Download this repo or fork
- Rename defines-sample.php to defines.php
- Configuration all files in configs folder
- Write in console: "composer update"
- Run public/init.php file
- Add new polls in DB tables
- Setup cron task on public/run.php. Don't forget get parameter (?token=SECRET_KEY)
- Rename .htaccess.example to .htaccess and change ip. (for additional protection)

## Folder structure:
- configs (all configuration)
- public
  - controllers (index.php uses these files)
  - css (index.php uses these files)
  - js (index.php uses these files)
  - callback.php (receives a response from the server VK)
  - index.php (frontend, to add new polls and other)
  - init.php (initial setting, DB)
  - parse.php (parse data from other sites) *cron
  - run.php (primary boot file)
  - vk.php (sending data to the VK server) *cron
- resources
  - card (contains folders, and in them on 50 files. Files contain a training card with a word. 1 file is loaded)
  - fun (contains folders, and in them on 50 files. Files contain a a funny picture or a quote (mostly). 1 file is loaded)
  - img (contains a folder with 50 folders. These 50 folders contain 1 to 10 files. Files of training nature. The entire folder is downloaded to the server)
- src
  - libs (downloaded outside the composer)
  - vk (core)
  - youtube
  - other base files
- templates (contains custom events - game, euro2017, etc.)

## To-do list:
- One video - several albums
- Relations in DB
- Transfer youtube_playlist from Config table in new own table
- Check for file upload in VK server and error handling
- Log file
- ..

## License
MIT
