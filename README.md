# Automation Group VK (in development)

## Requirements:
```
php 7.2 or newer
extension pdo_mysql
```

## Request params:
**To run the script (configs/defines.php - APP_SECRET):**
```
secret
```
*Example:*
```
https://example.com/?secret=123
```
**To select a token (configs/tokens.php):**
```
t_site
t_type
t_access
```
*Example:*
```
https://example.com/?t_site=vk&t_type=user&t_access=photo,video
```

## License
MIT
