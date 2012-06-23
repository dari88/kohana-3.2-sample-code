kohanaPress
===========
**The kohanaPress is WordPress style blog system driven by kohana.**
Demo site: http://bit.ly/KSJ8Hc
 
V1.3 2012.06.07
---------------
- The name changed to "kohanaPress".
- Added functions to manipulate the post.

V1.2 2012.06.01
---------------
- Added media delete function.
- Media view with ThickBox jQuery plugin.


V1.1 2012.05.26
---------------
- Added media upload function.
- This function uses Uploadify and ImageMgick.
- You must install ImageMagick and Imagick.
- Place 'uploads' folder under the document root(htdocs).
- Image data will be stored in MySQL database by binary code.


V1.0 2012.05.19
---------------
- The test12 is emulation code of WordPress.
- Now you can do only get user acount, login, post new article.
- Place 'includes' folder under the document root(htdocs).
- Create tables in the kohana database by `application/classes/model/test12/wordpress.sql,wp_post_images.sql`
- Write to the `config/database.php` file your user name and password for the kohana database.
- A SMTP server is needed on your PC.
- The ZendFramework is needed under `kohana/application/vendor/Zend/` folder.

Acsess: http://localhost/kohana/test12

**//by dari88**
