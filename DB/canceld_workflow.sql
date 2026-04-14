
INSERT INTO `statuses` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES (11, 'Canceled', '1', NULL, NULL);



/** for rejected creator managment **/


INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ('4', '1', '4', '1', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '1', '1');

INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '4', '1', '4', '1', '11', '1', '2022-08-16 10:17:52', '2022-08-17 10:55:11', '1', '1', '2');


INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '7', '1', '4', '1', '11', '1', '2022-08-16 11:06:25', '2022-08-16 12:43:56', '1', '1', '3');

INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ('1', '1', '11', '1', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '1', '1');
INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ('1', '1', '11', '1', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '1', '2');

INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ('1', '1', '11', '1', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '1', '3');

/*** return for correction managment **/
INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ('8', '1', '6', '1', '11', '1', '2022-08-16 10:39:18', '2022-08-16 12:27:37', '1', '1', '1');

INSERT INTO `workflows` (`previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ('8', '1', '6', '1', '11', '1', '2022-08-16 10:39:18', '2022-08-17 10:55:47', '1', '1', '2');

INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '8', '1', '6', '1', '11', '1', '2022-08-16 11:07:41', '2022-08-16 12:44:53', '1', '1', '3');

/**** reject for db recovery***/
INSERT INTO `workflows` (`previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '4', '10', '4', '10', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '10', '1');
INSERT INTO `workflows` (`previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '4', '10', '4', '10', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '10', '2');


INSERT INTO `workflows` (`previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '7', '10', '4', '10', '11', '1', '2022-08-16 11:06:25', '2022-08-16 12:43:56', '1', '10', '3');


INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '10', '10', '11', '10', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '10', '1');
INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '10', '10', '11', '10', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '10', '2');
INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '10', '10', '11', '10', '11', '1', '2022-08-16 10:17:52', '2022-08-16 12:19:34', '1', '10', '3');

/*** return for correction db **/
INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '8', '10', '6', '10', '11', '1', '2022-08-16 10:39:18', '2022-08-16 12:27:37', '1', '10', '1');

INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '8', '10', '6', '10', '11', '1', '2022-08-16 10:39:18', '2022-08-16 12:27:37', '1', '10', '2');

INSERT INTO `workflows` ( `previous_group`, `current_group`, `current_status`, `transfer_group`, `transfer_status`, `active`, `created_at`, `updated_at`, `category_id`, `creator_group_id`, `transaction_type_id`) VALUES ( '8', '10', '6', '10', '11', '1', '2022-08-16 11:07:41', '2022-08-16 12:44:53', '1', '10', '3');
