-- /*******************************************************
-- *
-- * civicrm_membersonlyevent
-- *
-- * Members Only Event entity settings table
-- *
-- *******************************************************/
CREATE TABLE `civicrm_membersonlyevent` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique Members Only Event ID',
     `event_id` int unsigned NOT NULL   COMMENT 'Foreign key for the Event',
     `price_field_id` int unsigned    COMMENT 'Foreign key for the Price field id',
     `is_members_only_event` tinyint   DEFAULT 0 COMMENT 'If this box is ticked only the users with permission "Can register for Members only events" will be able to register for this event.'
,
    PRIMARY KEY ( `id` )


,          CONSTRAINT FK_civicrm_membersonlyevent_event_id FOREIGN KEY (`event_id`) REFERENCES `civicrm_event`(`id`) ON DELETE CASCADE
,          CONSTRAINT FK_civicrm_membersonlyevent_price_field_id FOREIGN KEY (`price_field_id`) REFERENCES `civicrm_price_field`(`id`) ON DELETE SET NULL
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;

CREATE TABLE `civicrm_membersonlyevent_config` (


     `id` int unsigned NOT NULL AUTO_INCREMENT,
     `duration_check` tinyint   DEFAULT 0  COMMENT 'Enable membership duration check?',
     
    PRIMARY KEY ( `id` )
  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;

INSERT INTO civicrm_membersonlyevent_config (`duration_check`) VALUES (0);

-- /*******************************************************
-- *
-- * civicrm_membersonlyevent_memberprice
-- *
-- * Members Event prices for memberships purchasing
-- *
-- *******************************************************/
CREATE TABLE `civicrm_membersonlyevent_memberprice` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique EventMemberPrice ID',
     `event_id` int unsigned NOT NULL   COMMENT 'Foreign key for the Event',
     `price_value_id` int unsigned NOT NULL   COMMENT 'Foreign key for the Price Value',
     `membership_type_id` int unsigned NOT NULL   COMMENT 'Foreign key for the Membership Type'
,
    PRIMARY KEY ( `id` )


,          CONSTRAINT FK_civicrm_membersonlyevent_memberprice_event_id FOREIGN KEY (`event_id`) REFERENCES `civicrm_event`(`id`) ON DELETE CASCADE
,          CONSTRAINT FK_civicrm_membersonlyevent_memberprice_price_value_id FOREIGN KEY (`price_value_id`) REFERENCES `civicrm_price_field_value`(`id`) ON DELETE CASCADE
,          CONSTRAINT FK_civicrm_membersonlyevent_memberprice_membership_type_id FOREIGN KEY (`membership_type_id`) REFERENCES `civicrm_membership_type`(`id`) ON DELETE CASCADE
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;