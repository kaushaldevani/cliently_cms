# cliently_cms
	


1) Create A DB in MYSQL and name it 'cliently_cms_backend' and then using below script create a table
   CREATE TABLE `page` (`id` int(11) NOT NULL AUTO_INCREMENT,`page_name` varchar(255) DEFAULT NULL,`written_by` varchar(255) DEFAULT NULL,
   `job_title` varchar(255) DEFAULT NULL,`action_data` json DEFAULT NULL,`similar_camp_data` json DEFAULT NULL, `tips` longtext NOT NULL,
   `author_image` text NOT NULL,`wordpress_id` int(11) NOT NULL DEFAULT '0',PRIMARY KEY (`id`), UNIQUE KEY `page_name` (`page_name`)) 

2) Create another table as per below script and add entry for user_name and password
   note that for password we are using md5.
   
   CREATE TABLE `user` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_name` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,PRIMARY KEY (`id`)) 

3) Add .env file in project root directory as per '.env.example' file 
   which includes DB(servername, username and password ) credentials as well as for also wordpress(wp_username ,wp_password,wordpress_url)
   For wordpress url - replace wordpress_url with your wordpress url , where '/wp-json/wp/v2/pages' part will remain as it is




