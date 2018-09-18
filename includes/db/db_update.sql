--
-- Changes in `camp_campaings`
--
# Add "date" in YYYYMMDD format

# Drop "id_ref"
ALTER TABLE `camp_campaings` DROP `id_ref`;


--
-- Changes in `camp_tombs`
--
# Change "id_spot" to "id_waypoint"
ALTER TABLE `camp_tombs` CHANGE `id_spot` `id_waypoint` INT(10) UNSIGNED NOT NULL DEFAULT '0'; 
# Drop "id_ref"
ALTER TABLE `camp_tombs` DROP `id_ref`;


--
-- Changes in `camp_waypoints`
--
# Change "camp_spots" to "camp_waypoints"
ALTER TABLE camp_spots RENAME TO camp_waypoints;
# Alter "latitude" size to (8,6)

# Alter "longitude" size to (8,6)

# Alter "date" to "time" and change it's data type (DATETIME or TIMESTAMP)

# Add "elevation" and define it's data type
ALTER TABLE `camp_waypoints` ADD `elevation` DECIMAL(10,6) UNSIGNED NULL AFTER `longitude`
# Add "symbol" and define it's data type
ALTER TABLE `camp_waypoints` ADD `symbol` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Flag, Blue' AFTER `date`; 
# Drop "id_ref"
ALTER TABLE `camp_waypoints` DROP `id_ref`;


--
-- Changes in `sp_species`
--
# Alter "gender" to "genus"
ALTER TABLE `sp_species` CHANGE `gender` `genus` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
# Drop "id_ref"
ALTER TABLE `sp_species` DROP `id_ref`;
