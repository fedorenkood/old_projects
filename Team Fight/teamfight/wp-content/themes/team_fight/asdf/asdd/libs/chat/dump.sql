-- phpMyAdmin SQL Dump
-- version 2.9.0
-- http://www.phpmyadmin.net

-- --------------------------------------------------------

-- 
-- Структура таблицы `tf_dialog`
-- 

CREATE TABLE `tf_dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public` int(11) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `tf_dialog` (`id`, `public`, `hash`, `userid`) VALUES
(4, 1364454719, 'zPcfYXgp', 2);
-- --------------------------------------------------------

-- 
-- Структура таблицы `tf_message`
-- 

CREATE TABLE `tf_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `public` int(11) NOT NULL,
  `senderid` int(11) NOT NULL,
  `dialogid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `tf_message_to_user`
-- 

CREATE TABLE `tf_message_to_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messageid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `tf_user`
-- 

CREATE TABLE `tf_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `steamid` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `csgo` int(11) NOT NULL,
  `dota` int(11) NOT NULL,
  `lang` int(11) NOT NULL,
  `prem` BOOLEAN NOT NULL,
  `email` varchar(50) NOT NULL,
  `perm` varchar(50) NOT NULL DEFAULT '0|1|1|0|1|1',
  `public` int(11) NOT NULL,
  `lastvisit` int(11) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `access` int(11) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `method_notification` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `tf_user_to_dialog`
-- 

CREATE TABLE `tf_user_to_dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `dialogid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
