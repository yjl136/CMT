<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function showFlightList(){
        $page = $_GET["page"];
        $service = new FlightService();
        $result = $service->getFlightList($page);

        $this->Tmpl['list']	= $result['list'];
        $this->Tmpl['page_nav']	= $result['page_nav'];
        $this->display();
    }

    public function showFlightInfo(){
        $id = $_GET["id"];

        $service = new FlightService();
        $flight = $service->getFlightByID($id);

        $this->Tmpl["flight"] = $flight;
        $this->changeMenuKey();
        $this->display();
    }

    public function showPassengerList(){
        $page = $_GET["page"];
        $service = new FlightService();
        $result = $service->getPassengerList($page);

        $this->Tmpl['list']	= $result['list'];
        $this->Tmpl['page_nav']	= $result['page_nav'];
        $this->display();
    }

    public function showPassengerInfo(){
        $id = $_GET["id"];
        $service = new FlightService();
        $passenger = $service->getPassengerByID($id);

        $this->Tmpl["passenger"] = $passenger;
        $this->changeMenuKey();
        $this->display();
    }

}
