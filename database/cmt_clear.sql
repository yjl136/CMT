DELETE FROM cmt_operate;

DELETE FROM oam_monitorparamvalue;
DELETE FROM oam_biteparamvalue;
DELETE FROM oam_device where DevType <> 13;
DELETE FROM oam_calibrationconfig;
DELETE FROM oam_harddiskparam;
DELETE FROM oam_alarmmessage;