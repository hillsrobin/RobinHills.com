SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) NOT NULL auto_increment,
  `filename` text NOT NULL,
  `caption` text NOT NULL,
  `owner` bigint(20) NOT NULL,
  `uploadDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;



-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) NOT NULL auto_increment,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `image` bigint(20) NOT NULL,
  `categories` text NOT NULL,
  `tags` text NOT NULL,
  `postDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` bigint(20) NOT NULL,
  `status` enum('active','draft','disabled') NOT NULL default 'active',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL auto_increment,
  `username` text NOT NULL,
  `password` varchar(120) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstName`, `lastName`) VALUES
(1, 'admin', md5('supersecret'), 'Admin', 'User');

-- Add host_id to posts table (for multi-site support)
ALTER TABLE posts ADD host_id SMALLINT default 1 AFTER id, ADD INDEX (host_id);
