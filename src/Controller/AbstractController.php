<?php

namespace Sigita\Controller;

use http\Exception;
use Sigita\Config\Parameters;
use Sigita\Model\DB;

abstract class AbstractController
{
    protected $db;
    protected $login;

    public function render($fileName, $variables = array())
    {
        $filePath = __DIR__ . "/../Views/$fileName";
        if (file_exists($filePath)) {
            extract($variables);
            include $filePath;
        } else {
            exit("system component not found");
        }
    }

    protected function getDB()
    {
        $this->db = new DB(Parameters::getConnectionUrl(), Parameters::getConnectionUser(), Parameters::getConnectionPassword());
        return $this->db;
    }
}