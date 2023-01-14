# Library of non read books

A reading management app to save info about your future reads, the books you already read and more.
Includes an import feature to parse big amounts of data in a .txt file with title, author, and read state (0 unread, 1 read) divided by "-".

## Set up
``docker-compose up`` in the .yml folder.

To see the nginx files go to ``127.0.0.1`` not localhost. Files need to be placed in /app/public.

Inspiration taken from [here](https://www.sitepoint.com/docker-php-development-environment/)

## PHPMyAdmin
To enter in the graphic interface of the database go to [http://127.0.0.1:8081](http://127.0.0.1:8081) and enter server: mysql, user: nada and password: secret.