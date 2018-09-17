<?php

namespace Sigita\Controller;

use http\Exception;
use Sigita\Model\DB;

class IndexController extends AbstractController
{
    public function indexAction($emptyField=false)
    {
        $this->render("index.html",  array("emptyField"=>$emptyField));
    }

    public function orderAction()
    {
        if (!empty($_POST["formdata"]["name"]) && !empty($_POST["formdata"]["lastname"]) && !empty($_POST["formdata"]["email"])
            && !empty($_POST["formdata"]["number"])
            && !empty($_POST["formdata"]["address"])) {
            $data = $_POST["formdata"];
            $db = $this->getDB();
            $db->insert($data);
            $this->render("gotForm.html", array("name" => "j"));
        }
        if (empty($_POST["formdata"]["name"]) ||empty($_POST["formdata"]["lastname"]) ||empty($_POST["formdata"]["email"])
            ||empty($_POST["formdata"]["number"])
            ||empty($_POST["formdata"]["address"])) {
            $emptyField=true;
            $this->indexAction($emptyField);
        }
    }
}
