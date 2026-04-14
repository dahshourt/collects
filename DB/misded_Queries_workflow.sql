/*
-- Query: select * from workflows where creator_group_id=10 and transfer_status=5 and current_group=8  and current_status=7 and transaction_type_id=2
LIMIT 0, 1000

-- Date: 2023-03-01 12:35
*/
INSERT INTO `workflows` (`previous_group`,`current_group`,`current_status`,`transfer_group`,`transfer_status`,`active`,`created_at`,`updated_at`,`category_id`,`creator_group_id`,`transaction_type_id`) VALUES (8,8,7,1,'5','1','2022-08-16 10:05:44','2022-08-16 12:14:05',1,10,2);
INSERT INTO `workflows` (`previous_group`,`current_group`,`current_status`,`transfer_group`,`transfer_status`,`active`,`created_at`,`updated_at`,`category_id`,`creator_group_id`,`transaction_type_id`) VALUES (8,8,7,1,'5','1','2022-08-16 10:05:44','2022-08-16 12:14:05',1,10,1);


INSERT INTO `workflows` (`previous_group`,`current_group`,`current_status`,`transfer_group`,`transfer_status`,`active`,`created_at`,`updated_at`,`category_id`,`creator_group_id`,`transaction_type_id`) VALUES (8,8,7,1,'5','1','2022-08-16 10:05:44','2022-08-16 12:14:05',1,1,1);
INSERT INTO `workflows` (`previous_group`,`current_group`,`current_status`,`transfer_group`,`transfer_status`,`active`,`created_at`,`updated_at`,`category_id`,`creator_group_id`,`transaction_type_id`) VALUES (8,10,7,1,'5','1','2022-08-16 10:05:44','2022-08-16 12:14:05',1,1,2);
INSERT INTO `workflows` (`previous_group`,`current_group`,`current_status`,`transfer_group`,`transfer_status`,`active`,`created_at`,`updated_at`,`category_id`,`creator_group_id`,`transaction_type_id`) VALUES (8,8,7,1,'5','1','2022-08-16 10:05:44','2022-08-16 12:14:05',1,1,2);
