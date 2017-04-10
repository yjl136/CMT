SET NAMES utf8;
UPDATE cmt_admin_user SET password =md5('26983727')  WHERE type='super';
UPDATE cmt_admin_user SET password = md5('2016') WHERE type='operate';
UPDATE cmt_admin_user SET password =md5('666666')  WHERE type='config';
UPDATE cmt_admin_user SET password = md5('999999999') WHERE type='debug';
DELETE FROM oam_mail_user;
INSERT INTO `oam_mail_user` VALUES ('techsupports@donica.com', 'Donica@26983727', '123.125.50.210', '25');

UPDATE cmt_auto_export SET export_url = '120.77.72.20', export_username='donicaftp', export_password='Donicaftp2017!'  WHERE export_id='1';
