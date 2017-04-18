<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','HomeController@home');
Route::get('/home/switchWifi/{mode}','HomeController@showSwitchWifi');
Route::get('/home/switch4G/{mode}','HomeController@showSwitch4G');
Route::get('/logout','IndexController@logout');
Route::post('/loginWithPassword','IndexController@loginWithPassword');
Route::get('/topo','DeviceController@topo');
Route::get('/flight','HomeController@flight');
Route::get('/showDevice/{mac}','DeviceController@deviceDetail');
Route::get('/showBiteResult/{mac}','SystemController@biteResult');
Route::get('/showDevice/{mac}/{alarmInfo}','DeviceController@deviceAlarmInfo');
Route::get('/list','DeviceController@deviceList');
Route::get('/common/error','CommonController@showError');
Route::get('/common/progError','CommonController@showProgError');
Route::get('/validate/mail','ConfigController@senderValidate');

/**
 * Config控制器中的一些操作
 */
Route::get('/receiver','ConfigController@receiver');
Route::any('/receiver/edit/{mail_type}','ConfigController@receiverEdit');
Route::get('/sender','ConfigController@sender');
Route::any('/sender/edit/{user_id}','ConfigController@senderEdit');
Route::get('/users','ConfigController@user');
Route::any('/users/edit/{user_type}','ConfigController@userEdit');
Route::any('/http','ConfigController@usbconfig');
Route::any('/transmission','ConfigController@transmission');
Route::any('/transmissionsave','ConfigController@transmissionsave');
Route::any('/system','ConfigController@sysConfig');
Route::any('/timesync','ConfigController@timesync');
Route::any('/server','ConfigController@serverConfig');
Route::any('/cap','ConfigController@capConfig');
Route::any('/network','ConfigController@networkModeConfig');

/**
 * System控制器中的一些操作
 */
Route::get('/bite','SystemController@bite');
Route::get('/bite/startBite/{dev_id}','SystemController@showStartBite');
Route::get('/sysTest','SystemController@sysTest');
Route::get('/sysTest/switchWifi/{mode}','SystemController@showSwitchWifi');
Route::get('/sysTest/switchWifiMode/{mode}','SystemController@showSwitchWifiMode');
Route::get('/sysTest/switch4G/{mode}','SystemController@showSwitch4G');
Route::get('/sysTest/queryWifi','SystemController@showQueryWifi');
Route::get('/sysTest/queryWifiMode','SystemController@showQueryWifiMode');
Route::get('/sysTest/switchAP/{mode}/{positionID}','SystemController@showSwitchAP');
Route::get('/sysTest/resetFactory','SystemController@showResetFactory');
Route::get('/sysTest/logOperation','SystemController@showLogOperation');
Route::get('/sysTest/showSwitchATG','SystemController@showSwitchATG');
Route::get('/version','SystemController@version');

/**
 * Syslog控制器中的一些操作
 */
Route::get('/alarmLog','SyslogController@alarmLog');
Route::get('/dialLog','SyslogController@dialLog');
Route::get('/flightLog','SyslogController@flightLog');
Route::get('/operateLog','SyslogController@operateLog');
Route::get('/runningLog','SyslogController@runningLog');

/**
 * Upgrade控制器中的一些操作
 */
Route::get('/sysUpgrade','UpgradeController@sysUpgrade');
Route::get('/sysUpgrade/checkTransWay/{way?}','UpgradeController@showCheckTransWay');
Route::get('/sysUpgrade/copyPackage','UpgradeController@showCopyPackage');
Route::get('/sysUpgrade/queryCopyProgress','UpgradeController@showQueryCopyProgress');
Route::get('/sysUpgrade/queryVersion','UpgradeController@showQueryVersion');
Route::get('/sysUpgrade/querySysUpdate','UpgradeController@showQuerySysUpdate');
Route::get('/sysUpgrade/copyProgress','UpgradeController@showQuerySysUpdate');
Route::get('/sysUpgrade/reboot/{target}','UpgradeController@showReboot');
Route::get('/sysUpgrade/querySysUpdateProgress/{target?}','UpgradeController@showQuerySysUpdateProgress');
Route::get('/sysUpgrade/startUpdate/{target?}','UpgradeController@showStartUpdate');
Route::get('/sysBackup/{do?}','UpgradeController@sysBackup');
Route::get('/progUpdate','UpgradeController@progUpdate');
Route::get('/progUpdate/checkTransWay/{way?}','UpgradeController@showCheckTransWay');
Route::get('/progUpdate/queryProgUpdate/{way?}','UpgradeController@showQueryProgUpdate');
Route::get('/progUpdate/queryProgVersion','UpgradeController@showQueryProgVersion');
Route::get('/progUpdate/startProgUpdate/{way}','UpgradeController@showStartProgUpdate');
Route::get('/progUpdate/queryProgUpdateProgress/{way}','UpgradeController@showQueryProgUpdateProgress');
Route::get('/progUpdate/cleanup','UpgradeController@showCleanup');

/**
 * Data控制器中的一些操作
 */
Route::get('/dataExport','DataController@dataExport');
Route::get('/dataExport/checkTransWay/{way?}','DataController@showCheckTransWay');
Route::get('/dataExport/exportData/{way?}/{format_type?}/{start_time?}/{end_time?}','DataController@showExportData');
Route::get('/dataExport/queryProgress/{way?}/{content_type?}/{format_type?}/{start_time?}/{end_time?}','DataController@showQueryProgress');
Route::get('/autoExport','DataController@autoExport');
Route::get('/autoExport/autoExportConfig/{exportTactics}/{exportDays}/{exportWeeks}/{exportMonths}/{exportInputChecked}','DataController@showAutoExportConfig');


/**
 * 用户为运营管理的权限范围
 */
Route::get('/operate/topo','OperateController@topo');
Route::get('/operate/flight','OperateController@flight');


/**
 * 用户为出厂调试的权限范围
 */
Route::get('/factoryset/customizeSetting','FactorysetController@factoryset');



/**
 * 用户为系统维护的权限范围
 */
Route::get('/maintenance/topo','MaintenanceController@topo');
Route::get('/maintenance/flight','MaintenanceController@flight');
Route::get('/maintenance/list','MaintenanceController@deviceList');
Route::get('/maintenance/showDevice/{mac}','MaintenanceController@deviceDetail');
Route::get('/maintenance/showDevice/{mac}/{alarmInfo}','MaintenanceController@deviceAlarmInfo');
Route::get('/maintenance/bite','MaintenanceController@bite');
Route::get('/maintenance/showBiteResult/{mac}','MaintenanceController@biteResult');
Route::get('/maintenance/sysUpgrade','MaintenanceController@sysUpgrade');
Route::get('/maintenance/sysBackup/{do?}','MaintenanceController@sysBackup');
Route::get('/maintenance/progUpdate','MaintenanceController@progUpdate');
Route::get('/maintenance/dataExport','MaintenanceController@dataExport');
Route::get('/maintenance/autoExport','MaintenanceController@autoExport');
Route::get('/maintenance/sysTest','MaintenanceController@sysTest');
Route::get('/maintenance/alarmLog','MaintenanceController@alarmLog');
Route::get('/maintenance/dialLog','MaintenanceController@dialLog');
Route::get('/maintenance/flightLog','MaintenanceController@flightLog');
Route::get('/maintenance/operateLog','MaintenanceController@operateLog');
Route::get('/maintenance/runningLog','MaintenanceController@runningLog');
Route::get('/maintenance/version','MaintenanceController@version');






/**
 * 查询一些状态值及参数值api
 */
Route::get('/api/dashboard','DashboardController@queryValue');
Route::get('/api/getStatus','DashboardController@status');
Route::get('/api/onekeyBite','DashboardController@onekeyBite');
Route::get('/api/getNewVersion','HomeController@newVersionInfo');





