# cliently_cms


For Back End

1) Create a Databse in MYSQL and name it 'cliently_cms_backend' and then creat a table using below Script

    CREATE TABLE `page` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `page_name` varchar(255) DEFAULT NULL,
 `written_by` varchar(255) DEFAULT NULL,
 `job_title` varchar(255) DEFAULT NULL,
 `action_data` json DEFAULT NULL,
 `similar_camp_data` json DEFAULT NULL,
 `tips` longtext NOT NULL,
 `author_image` text NOT NULL,
 `wordpress_id` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 UNIQUE KEY `page_name` (`page_name`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1

2) Now go to 'cliently_cms/config/dbconfig.php' and change $servername, $username and $password as you have set for Database in step-1

3) Go to 'cliently_cms/api/wordpress_upsert.php' and change wp_username,wp_password with your wordpress user name password
   and replace wordpress_url with your wordpress url , where '/wp-json/wp/v2/pages' part will remain as it is.
