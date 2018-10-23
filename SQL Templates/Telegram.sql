SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `Telegram` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
USE `Telegram`;

CREATE TABLE IF NOT EXISTS `botan_shortener` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Unique identifier for this entry',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `url` text COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'Original URL',
  `short_url` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '' COMMENT 'Shortened URL',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `callback_query` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Unique identifier for this query',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Unique message identifier',
  `inline_message_id` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Identifier of the message sent via the bot in inline mode, that originated the query',
  `data` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '' COMMENT 'Data associated with the callback button',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `chat` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user or chat identifier',
  `type` enum('private','group','supergroup','channel') COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'Chat type, either private, group, supergroup or channel',
  `title` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT '' COMMENT 'Chat (group) title, is null if chat type is private',
  `username` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Username, for private chats, supergroups and channels if available',
  `all_members_are_administrators` tinyint(1) DEFAULT '0' COMMENT 'True if a all members of this group are admins',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update',
  `old_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier, this is filled when a group is converted to a supergroup'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `chosen_inline_result` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Unique identifier for this entry',
  `result_id` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '' COMMENT 'Identifier for this result',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `location` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Location object, user''s location',
  `inline_message_id` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Identifier of the sent inline message',
  `query` text COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'The query that was used to obtain the result',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `conversation` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Unique identifier for this entry',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `status` enum('active','cancelled','stopped') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'active' COMMENT 'Conversation state',
  `command` varchar(160) COLLATE utf8mb4_unicode_520_ci DEFAULT '' COMMENT 'Default command to execute',
  `notes` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Data stored from command',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `edited_message` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Unique identifier for this entry',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Unique message identifier',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `edit_date` timestamp NULL DEFAULT NULL COMMENT 'Date the message was edited in timestamp format',
  `text` text COLLATE utf8mb4_unicode_520_ci COMMENT 'For text messages, the actual UTF-8 text of the message max message length 4096 char utf8',
  `entities` text COLLATE utf8mb4_unicode_520_ci COMMENT 'For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text',
  `caption` text COLLATE utf8mb4_unicode_520_ci COMMENT 'For message with caption, the actual UTF-8 text of the caption'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `inline_query` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Unique identifier for this query',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `location` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Location of the user',
  `query` text COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'Text of the query',
  `offset` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Offset of the result',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `message` (
  `chat_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique chat identifier',
  `id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Unique message identifier',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `date` timestamp NULL DEFAULT NULL COMMENT 'Date the message was sent in timestamp format',
  `forward_from` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier, sender of the original message',
  `forward_from_chat` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier, chat the original message belongs to',
  `forward_from_message_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier of the original message in the channel',
  `forward_date` timestamp NULL DEFAULT NULL COMMENT 'date the original message was sent in timestamp format',
  `reply_to_chat` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `reply_to_message` bigint(20) unsigned DEFAULT NULL COMMENT 'Message that this message is reply to',
  `media_group_id` text COLLATE utf8mb4_unicode_520_ci COMMENT 'The unique identifier of a media message group this message belongs to',
  `text` text COLLATE utf8mb4_unicode_520_ci COMMENT 'For text messages, the actual UTF-8 text of the message max message length 4096 char utf8mb4',
  `entities` text COLLATE utf8mb4_unicode_520_ci COMMENT 'For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text',
  `audio` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Audio object. Message is an audio file, information about the file',
  `document` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Document object. Message is a general file, information about the file',
  `photo` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Array of PhotoSize objects. Message is a photo, available sizes of the photo',
  `sticker` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Sticker object. Message is a sticker, information about the sticker',
  `video` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Video object. Message is a video, information about the video',
  `voice` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Voice Object. Message is a Voice, information about the Voice',
  `video_note` text COLLATE utf8mb4_unicode_520_ci COMMENT 'VoiceNote Object. Message is a Video Note, information about the Video Note',
  `contact` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Contact object. Message is a shared contact, information about the contact',
  `location` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Location object. Message is a shared location, information about the location',
  `venue` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Venue object. Message is a Venue, information about the Venue',
  `caption` text COLLATE utf8mb4_unicode_520_ci COMMENT 'For message with caption, the actual UTF-8 text of the caption',
  `new_chat_members` text COLLATE utf8mb4_unicode_520_ci COMMENT 'List of unique user identifiers, new member(s) were added to the group, information about them (one of these members may be the bot itself)',
  `left_chat_member` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier, a member was removed from the group, information about them (this member may be the bot itself)',
  `new_chat_title` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'A chat title was changed to this value',
  `new_chat_photo` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Array of PhotoSize objects. A chat photo was change to this value',
  `delete_chat_photo` tinyint(1) DEFAULT '0' COMMENT 'Informs that the chat photo was deleted',
  `group_chat_created` tinyint(1) DEFAULT '0' COMMENT 'Informs that the group has been created',
  `supergroup_chat_created` tinyint(1) DEFAULT '0' COMMENT 'Informs that the supergroup has been created',
  `channel_chat_created` tinyint(1) DEFAULT '0' COMMENT 'Informs that the channel chat has been created',
  `migrate_to_chat_id` bigint(20) DEFAULT NULL COMMENT 'Migrate to chat identifier. The group has been migrated to a supergroup with the specified identifier',
  `migrate_from_chat_id` bigint(20) DEFAULT NULL COMMENT 'Migrate from chat identifier. The supergroup has been migrated from a group with the specified identifier',
  `pinned_message` text COLLATE utf8mb4_unicode_520_ci COMMENT 'Message object. Specified message was pinned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `request_limiter` (
`id` bigint(20) unsigned NOT NULL COMMENT 'Unique identifier for this entry',
  `chat_id` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Unique chat identifier',
  `inline_message_id` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Identifier of the sent inline message',
  `method` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'Request method',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `telegram_update` (
  `id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Update''s unique identifier',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Unique message identifier',
  `inline_query_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Unique inline query identifier',
  `chosen_inline_result_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Local chosen inline result identifier',
  `callback_query_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Unique callback query identifier',
  `edited_message_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Local edited message identifier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user identifier',
  `is_bot` tinyint(1) DEFAULT '0' COMMENT 'True if this user is a bot',
  `first_name` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '' COMMENT 'User''s first name',
  `last_name` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'User''s last name',
  `username` char(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'User''s username',
  `language_code` char(10) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'User''s system language',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `user_chat` (
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user identifier',
  `chat_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user or chat identifier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


ALTER TABLE `botan_shortener`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

ALTER TABLE `callback_query`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `chat_id` (`chat_id`), ADD KEY `message_id` (`message_id`), ADD KEY `chat_id_2` (`chat_id`,`message_id`);

ALTER TABLE `chat`
 ADD PRIMARY KEY (`id`), ADD KEY `old_id` (`old_id`);

ALTER TABLE `chosen_inline_result`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

ALTER TABLE `conversation`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `chat_id` (`chat_id`), ADD KEY `status` (`status`);

ALTER TABLE `edited_message`
 ADD PRIMARY KEY (`id`), ADD KEY `chat_id` (`chat_id`), ADD KEY `message_id` (`message_id`), ADD KEY `user_id` (`user_id`), ADD KEY `chat_id_2` (`chat_id`,`message_id`);

ALTER TABLE `inline_query`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

ALTER TABLE `message`
 ADD PRIMARY KEY (`chat_id`,`id`), ADD KEY `user_id` (`user_id`), ADD KEY `forward_from` (`forward_from`), ADD KEY `forward_from_chat` (`forward_from_chat`), ADD KEY `reply_to_chat` (`reply_to_chat`), ADD KEY `reply_to_message` (`reply_to_message`), ADD KEY `left_chat_member` (`left_chat_member`), ADD KEY `migrate_from_chat_id` (`migrate_from_chat_id`), ADD KEY `migrate_to_chat_id` (`migrate_to_chat_id`), ADD KEY `reply_to_chat_2` (`reply_to_chat`,`reply_to_message`);

ALTER TABLE `request_limiter`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `telegram_update`
 ADD PRIMARY KEY (`id`), ADD KEY `message_id` (`chat_id`,`message_id`), ADD KEY `inline_query_id` (`inline_query_id`), ADD KEY `chosen_inline_result_id` (`chosen_inline_result_id`), ADD KEY `callback_query_id` (`callback_query_id`), ADD KEY `edited_message_id` (`edited_message_id`);

ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`);

ALTER TABLE `user_chat`
 ADD PRIMARY KEY (`user_id`,`chat_id`), ADD KEY `chat_id` (`chat_id`);


ALTER TABLE `botan_shortener`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';
ALTER TABLE `chosen_inline_result`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';
ALTER TABLE `conversation`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';
ALTER TABLE `edited_message`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';
ALTER TABLE `request_limiter`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';

ALTER TABLE `botan_shortener`
ADD CONSTRAINT `botan_shortener_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `callback_query`
ADD CONSTRAINT `callback_query_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `callback_query_ibfk_2` FOREIGN KEY (`chat_id`, `message_id`) REFERENCES `message` (`chat_id`, `id`);

ALTER TABLE `chosen_inline_result`
ADD CONSTRAINT `chosen_inline_result_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `conversation`
ADD CONSTRAINT `conversation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `conversation_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`);

ALTER TABLE `edited_message`
ADD CONSTRAINT `edited_message_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`),
ADD CONSTRAINT `edited_message_ibfk_2` FOREIGN KEY (`chat_id`, `message_id`) REFERENCES `message` (`chat_id`, `id`),
ADD CONSTRAINT `edited_message_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `inline_query`
ADD CONSTRAINT `inline_query_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `message`
ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`),
ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`forward_from`) REFERENCES `user` (`id`),
ADD CONSTRAINT `message_ibfk_4` FOREIGN KEY (`forward_from_chat`) REFERENCES `chat` (`id`),
ADD CONSTRAINT `message_ibfk_5` FOREIGN KEY (`reply_to_chat`, `reply_to_message`) REFERENCES `message` (`chat_id`, `id`),
ADD CONSTRAINT `message_ibfk_6` FOREIGN KEY (`forward_from`) REFERENCES `user` (`id`),
ADD CONSTRAINT `message_ibfk_7` FOREIGN KEY (`left_chat_member`) REFERENCES `user` (`id`);

ALTER TABLE `telegram_update`
ADD CONSTRAINT `telegram_update_ibfk_1` FOREIGN KEY (`chat_id`, `message_id`) REFERENCES `message` (`chat_id`, `id`),
ADD CONSTRAINT `telegram_update_ibfk_2` FOREIGN KEY (`inline_query_id`) REFERENCES `inline_query` (`id`),
ADD CONSTRAINT `telegram_update_ibfk_3` FOREIGN KEY (`chosen_inline_result_id`) REFERENCES `chosen_inline_result` (`id`),
ADD CONSTRAINT `telegram_update_ibfk_4` FOREIGN KEY (`callback_query_id`) REFERENCES `callback_query` (`id`),
ADD CONSTRAINT `telegram_update_ibfk_5` FOREIGN KEY (`edited_message_id`) REFERENCES `edited_message` (`id`);

ALTER TABLE `user_chat`
ADD CONSTRAINT `user_chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_chat_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
