<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetController extends Controller
{
    public function showFactoryReset() {
        $this->display ();
    }

    public function showResetUser() {
        include_once 'lib/Service/UserService.php';
        $service = new UserService ();
        $flag = $service->resetPassword ();

        $result ["code"] = $flag ? "success" : "failed";
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    public function showClearCache() {
        include_once 'lib/Service/FactoryResetService.php';
        $service = new FactoryResetService ();
        $flag = $service->clearCache ();

        $result ["code"] = $flag ? "success" : "failed";
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    public function showResetTimezone() {
        include_once 'lib/Service/FactoryResetService.php';
        $service = new FactoryResetService ();
        $flag = $service->resetTimezone ();

        $result ["code"] = $flag ? "success" : "failed";
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    public function showResetDNS() {
        include_once 'lib/Service/FactoryResetService.php';
        $service = new FactoryResetService ();
        $flag = $service->resetDNS ();

        $result ["code"] = $flag ? "success" : "failed";
        echo json_encode ( $result );
        $this->exitSystem ();
    }

    public function showRecovery() {
        $do = $_GET ["do"];
        if (empty ( $do )) {
            $this->display ();
        } else {
            include_once 'lib/Service/FactoryResetService.php';
            $service = new FactoryResetService ();
            $flag = $service->recovery ();

            $result ["code"] = $flag ? "success" : "failed";
            echo json_encode ( $result );
            $this->exitSystem ();
        }
    }

    public function showCustomizeSetting() {
        $do = $_GET ["do"];

        $company = array ();
        $theme = array ();
        $language = array ();

        include_once 'lib/Service/CustomizeService.php';
        $service = new CustomizeService ();

        if ($do == "changeCompany") {
            $id = $_GET ["ID"];
            $company = $service->getCompanyByID($id);

            // change current setting to make effect immediately
            $service->changeCompanySetting ( $company );
        }else if ($do == "changeTheme") {
            $id = $_GET ["ID"];
            $theme = $service->getThemeByID($id);

            // change current setting to make effect immediately
            $service->changeThemeSetting ( $theme );
        }else if ($do == "changeLanguage") {
            $id = $_GET ["ID"];
            $language = $service->getLanguageByID($id);

            // change current setting to make effect immediately
            $service->changeLanguageSetting ( $language );
            header("Location:index.php?group=reset&module=reset&action=customizeSetting");
        }

        if (empty ( $company ))
            $company = $service->getCurrentCompanySetting ();
        if (empty ( $theme ))
            $theme = $service->getCurrentTheme ();
        if (empty ( $language ))
            $language = $service->getCurrentLanguage ();

        $company_count = $service->getGroupCount ();
        $theme_count = $service->getThemeCount ();
        $lang_count = $service->getLanguageCount ();
        $this->Tmpl ["company"] = $company;
        $this->Tmpl ["theme"] = $theme;
        $this->Tmpl ["language"] = $language;
        $this->Tmpl ["company_count"] = $company_count;
        $this->Tmpl ["theme_count"] = $theme_count;
        $this->Tmpl ["lang_count"] = $lang_count;
        $this->display ();
    }

    public function init() {
        // 验证是否登录
        check_login ();

        parent::init ();

        $this->Tmpl ['left_menu_id'] = "reset";
    }
}
