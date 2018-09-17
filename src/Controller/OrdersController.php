<?php

namespace Sigita\Controller;

use http\Exception;
use Sigita\Model\DB;
use Sigita\Config;

class OrdersController extends AbstractController
{
    protected $pageSize = 10;

    public function indexAction()
    {
        if (isset($_POST["user"]["name"]) && isset($_POST["user"]["password"])) {
            if ($_POST["user"]["name"] == Config\Parameters::getLogin() && $_POST["user"]["password"] == Config\Parameters::getPassword()) {
                $_SESSION["user"] = $_POST["user"];
            }
        }
        if (isset($_SESSION["user"])) {
            if (isset($_GET["sorting"])) {
                $sorting = $_GET["sorting"];
            } else {
                $sorting = "id";
            }
            if (isset($_GET["direction"])) {
                $direction = $_GET["direction"];
            } else {
                $direction = "asc";
            }
            if (isset($_GET["numberofpage"])) {
                $numOfPage = (int)$_GET["numberofpage"]; //vyksta kastinimas
            } else {
                $numOfPage = 1;
            }
            $search = null;
            if (isset($_POST["search"])) { //kadangi turejau post metoda, todel neveike, nes neeme
                $search = $_POST["search"];
            }
            if (isset($_GET["search"])) {
                $search = $_GET["search"];
            }

            $db = $this->getDB();
            $countOrders = $db->getOrdersCount($search);
            $numberOfPages = ceil($countOrders / $this->pageSize);
            $orders = $db->getOrders($sorting, $direction, $numOfPage, $this->pageSize, $search);
            $this->render(
                "orders.html",
                array(
                    "orders" => $orders,
                    "numberOfPages" => $numberOfPages,
                    "sorting" => $sorting,
                    "direction" => $direction,
                    "search" => $search
                )
               );
        }
        else {
            $this->loginAction();
        }
    }
    public function logoutAction()
    {
        unset($_SESSION["user"]);
        $this->loginAction();
    }
    public function loginAction()
    {
        $this->render("login.html");
    }
}
