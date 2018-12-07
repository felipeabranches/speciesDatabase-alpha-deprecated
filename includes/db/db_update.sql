--
-- Changes in `camp_campaings`
--
# Add "entity" and define its type
ALTER TABLE `camp_campaings` ADD `entity` varchar(255) COLLATE utf8_bin NOT NULL AFTER `name`;
# Add "date" in YYYYMMDD format
ALTER TABLE `camp_campaings` ADD `date` DATE NOT NULL AFTER `entity`;
# Drop "id_ref"
ALTER TABLE `camp_campaings` DROP `id_ref`;
# Correct table name renaming it from `camp_campaings` to `camp_campaigns`
RENAME TABLE `camp_campaings` TO `camp_campaigns`;

--
-- Changes in `camp_tombs`
--
# Drop "id_ref"
ALTER TABLE `camp_tombs` DROP `id_ref`;


--
-- Changes in `camp_waypoints`
--
# Alter "latitude" type of data to POINT
ALTER TABLE `camp_waypoints` CHANGE `latitude` `latitude` POINT NOT NULL;
# Alter "longitude" type of data to POINT
ALTER TABLE `camp_waypoints` CHANGE `longitude` `longitude` POINT NOT NULL;
# Alter "date" to "time" and change its data type (DATETIME or TIMESTAMP)
ALTER TABLE `camp_waypoints` CHANGE `date` `time` DATETIME NOT NULL;
# Add "elevation" and define its data type
ALTER TABLE `camp_waypoints` ADD `elevation` DECIMAL(10,6) UNSIGNED NULL AFTER `longitude`;
# Add "symbol" and define its data type
ALTER TABLE `camp_waypoints` ADD `symbol` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Flag, Blue' AFTER `time`;
# Drop "entity"
ALTER TABLE `camp_waypoints` DROP `entity`;
# Drop "id_ref"
ALTER TABLE `camp_waypoints` DROP `id_ref`;


--
-- Create `config_globals` table
--
CREATE TABLE `config_globals` (
  `author` VARCHAR(255) NOT NULL,
  `site_name` VARCHAR(255) NOT NULL,
  `bootstrap_cdn` BOOLEAN NOT NULL,
  `bootstrap_vsn` VARCHAR(255) NOT NULL,
  `tinymce_vsn` VARCHAR(255) NOT NULL
) ENGINE = MyISAM;


--
-- Changes in `sp_species`
--
# Alter "gender" to "genus"
ALTER TABLE `sp_species` CHANGE `gender` `genus` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


--
-- Create `users_users` table
--
CREATE TABLE `users_users` (
  `name` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARBINARY(255) NOT NULL
) ENGINE = MyISAM;
#Creates the user_type column
ALTER TABLE `users_users` ADD `id_user_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `password`;
#Configuration of the 'id' column
ALTER TABLE `users_users` ADD `id` INT(11) NOT NULL FIRST;
ALTER TABLE `users_users` ADD PRIMARY KEY(`id`);
ALTER TABLE `users_users` ADD UNIQUE(`id`);
ALTER TABLE `users_users` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;


--
-- Create `users_users_types` table
--
CREATE TABLE `users_users_types` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `order` TINYINT(3) NULL , `description` VARCHAR(5120) CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `note` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `image` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `published` TINYINT(1) NULL
) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_bin;
#Configuration of the 'id' column
ALTER TABLE `users_users_types` ADD PRIMARY KEY(`id`);
ALTER TABLE `users_users_types` ADD UNIQUE(`id`);
ALTER TABLE `users_users_types` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

