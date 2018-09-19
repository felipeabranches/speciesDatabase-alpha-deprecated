
ALTER TABLE `camp_campaings` ADD `date` DATE NULL AFTER `published`;
ALTER TABLE `camp_waypoints` CHANGE `latitude` `latitude` DECIMAL(8,6) NOT NULL;
ALTER TABLE `camp_waypoints` CHANGE `longitude` `longitude` DECIMAL(8,6) NOT NULL;
ALTER TABLE `camp_waypoints` CHANGE `date` `date` DATETIME NOT NULL;
ALTER TABLE `camp_waypoints` CHANGE `date` `time` DATETIME NOT NULL;