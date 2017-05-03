/**
 * 变量表示方法：%1$, %2$，以此类推，若要输出%用两个表示(%%),
 * 建议从下往上翻译(以免相同的句子已翻译被未翻译覆盖),翻译完成务必去除注释符(//)
 */
TRANS_MSGS = {
	"%1$年%2$月%3$日 %4$:%5$:%6$" : "%1$/%2$/%3$ %4$:%5$:%6$",
	// 查询框
	"查询条件" : "Search Condition",
	"查询" : "Search",

	// layer
	"提示" : "Info",
	"确定" : "OK",
	"取消" : "Cancel",
	"关闭" : "Close",
	"未知错误" : "Unknown error!",

	// style/js/validator.js
	"请输入必填项" : "required",
	"请输入正确的邮箱，如: aa@bb.cc" : "Please enter valid email, such as: aa@bb.cc",
	"请输入正确的IP，如: 192.168.0.1" : "Please enter valid IP, such as: 192.168.0.1",
	"请输入正确的Mac，如: 00:0c:e6:12:35:e1" : "Please enter valid Mac, e.g 00:0c:e6:12:35:e1",
	"请输入正确的身份证号(15或18位)" : "Please enter valid ID number (length of 15 or 18)",
	"请输入正确的日期格式，如: YYYY-mm-dd" : "Please enter valid date, such as: YYYY-mm-dd",
	"请输入正确的时间格式，如: YYYY-mm-dd HH:ii:ss" : "Please enter valid datetime, such as: YYYY-mm-dd HH:ii:ss",
	"请输入正确的网址，如: https://www.baidu.com/" : "Please enter valid url, such as: https://www.baidu.com/",
	"最少为6位，不能为纯数字、字母、符号" : "For at least six, not for the pure Numbers, letters, symbols",
	"必须输入7位数字" : "You must enter 7 digits",
	"只能输入1位数字或者2位数字或者不配置" : "Can only enter 1 digit or 2 digits or is not configured",
	"以字母数字开头，后面可接字母数字_-符号，长度4位以上" : "Begin with alphanumeric, behind may meet alphanumeric _ - symbol, the length of more than four",
	"字母数字加中文字符，和_符号" : "Alphanumeric with Chinese characters, and _ symbol",
	"开始日期不能晚于结束日期" : "Start date can not be later than end date",
	"开始时间不能晚于结束时间" : "Start time can not be later than end time",
	"只能输入1位数字或者2位数字或者不配置！" : "Can only enter 1 digit or 2 digits or is not configured!",

	// style/js/user.js
	"请输入用户名!" : "Please enter username!",
	"请输入密码!" : "Please enter password!",
	"用户名错误，请重新输入。" : "Invalid username",
	"密码输入错误，请重新输入。" : "Invalid password",
	"重复密码必须与新密码相同" : "Confirm password must be as same as new password.",
	
	"正在切换语言..." : "Switch language...",
	"正在置换CAP，请稍候..." : "Displacing CAP device, please wait for a moment...",
	"CAP置换完成，系统准备重启中..." : "CAP displacement complete!It is going to reboot system...",

	// style/js/detail.js
	"%1$ 可用，共 %2$" : "%1$ Avail, %2$ Total",
	// style/js/monitor.js
	"加载中..." : "Loading...",
	"无此类图形监控" : "No such graph type",

	// style/js/apconfig.js
	"确定要删除该AP吗？" : "Are you sure to delete this AP?",
	"删除成功。" : "Delete success.",
	"删除失败。" : "Delete failed.",

	// style/js/twlu.js
	"确定要删除该网络吗？" : "Are you sure to delete this network?",

	// style/js/mail.js
	"修改成功" : "Modify success",
	"修改失败" : "Modify failed",
	"请输入正确的端口(1-65535)" : "Please enter valid port (1-65535)",
	"正在校验..." : "Validating...",
	"校验成功" : "Email is valid!",
	"校验失败，邮箱或者密码错误" : "Validation failed, email or password is incorrect!",
	"校验失败，网络错误" : "Validation failed, network error!",

	// style/js/sysconfig.js
	"正在保存数据......" : "Saving data......",

	// style/js/calibrate.js
	"正在进行屏幕校准......" : "Screen Calibrating......",
	"屏幕校准成功!" : "Screen calibration succeed!",
	"屏幕校准失败!" : "Screen calibration failed!",

	// style/js/timesync.js
	"同步成功" : "Synchronize succeed",
	"同步失败" : "Synchronize failed",
	"等待重启..." : "Waiting for reboot......",
	"重启失败!" : "Reboot failed!",

	// style/js/bite.js
	"正在自检..." : "BITE...",

	// style/js/systemUpdate.js
	"正在检测USB..." : "Checking USB...",
	"正在拷贝更新包，请稍候！" : "Please wait for a moment for copying!",
	"正在升级系统，请稍候！" : "Please wait for a moment for upgrading!",
	"等待系统重启..." : "Waiting for system to reboot...",
	
	// style/js/deviceUpdate.js
	"正在检测部件版本..." : "Checking device version...",
	"不存在版本异常的设备！" : "Device with different versions is not existed!",
	"正在升级部件，请稍候！" : "Upgrading device, please wait for a moment!",

	// style/js/systemUpdate.js
	"正在检测..." : "Checking...",
	"正在升级节目，请稍候！" : "Please wait for a moment for upgrading!",
	"正在清理..." : "Clearing...",

	// style/js/systemBackup.js
	"正在进行系统备份......" : "Backuping...",
	"系统备份失败!" : "Backup failed!",

	// style/js/dataExport.js
	"至少选择一项格式" : "File format is required",
	"至少选择一项内容" : "Content type is required",
	"正在导出数据..." : "Exporting...",
	"导出数据超时！" : "Export data timeout",
	"数据传输超时" : "Transfer data timeout",

	// style/js/dataImport.js
	"正在导入数据..." : "Importing...",
	"文件格式错误！" : "Invalid file format!",

	// style/js/systemTest.js
	"手动模式剩余时间" : "Remain Time",
	"切换至%1$..." : "Switch to %1$...",
	"手动模式" : "manual mode",
	"自动模式" : "auto mode",
	"正在%1$..." : "going to %1$...",
	"开启WiFi" : "open WiFi",
	"关闭WiFi" : "close WiFi",
	"开启" : "open",
	"关闭" : "close",
	"[CAP-%1$]%2$超时" : "[CAP-%1$] %2$ timeout",
	"CPE%1$超时" : "CPE %2$ timeout",
	"确定恢复出厂设置吗？确定将进行出厂恢复，成功后重启服务器，启动后2分钟将会进行CAP置换工作，系统在进行CAP置换时无法使用。" : "Are you sure to do factory reset? Restoring the factory sure will, restart server after success, will there be a CAP replacement work start after 2 minutes, system cannot be used when making CAP replacement.",
	"恢复出厂设置"  :  "Factory Reset",
	"正在恢复出厂设置..." : "Reseting...",
	"恢复出厂设置失败" : "Factory reset failed",
	"恢复出厂设置完成，等待系统重启!" : "Factory reset completed and wait system restart!",
	"系统开启2分钟之后才能进行此项功能，请稍后再试!" : "Perform this function must wait 2 minutes after system open, please wait for a moment!",
	
	// style/js/systemTest.js
	"准备重启..." : "It is going to reboot...",
	"正在重启..." : "Restarting system...",
	
	// style/js/homepage.js
	"检测中......" : "Diagnosing......",
	"本次检测发现<a href=\"#\">%1$</a>个问题" : "<a href=\"#\">%1$</a> problem(s) found yet",
	
	"btn_jiance" : "btn_jiance_en",
	"btn_jiance_dis" : "btn_jiance_dis_en",
	
	// style/js/factoryReset.js
	"操作成功" : "Success",
	"操作失败" : "Failed",
	
	// style/js/padmanagement.js
	"音量必须在0~100范围内！" : "Volume must between 0 and 100!",
};
