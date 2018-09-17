<?php

namespace Sigita\Model;

use PDO;

class DB
{
    public $dbConnection;

    function __construct($connectionUrl, $connectionUser, $connectionPassword)
    {
        $this->dbConnection = new PDO($connectionUrl, $connectionUser, $connectionPassword);
        $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $data
     */
    public function insert($data)
    {
        try {
            $stmt = $this->dbConnection->prepare("INSERT INTO orders (Name,Last_Name,Email,Number, Address) 
    VALUES ( :Name, :Last_Name,:Email,:Number,:Address)");
            $stmt->bindValue(':Name', $data["name"]);
            $stmt->bindValue(':Last_Name', $data["lastname"]);
            $stmt->bindValue(':Email', $data["email"]);
            $stmt->bindValue(':Number', $data["number"]);
            $stmt->bindValue(':Address', $data["address"]);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getOrders($sorting, $direction, $numOfPage, $pageSize, $search)
    {
        try {
            $query = $this->getSqlQuery("*", $search, $sorting, $direction, $numOfPage, $pageSize);
            $stmt = $this->dbConnection->prepare($query);
            if ($search != null) {
                $stmt->bindValue(':search', "%$search%");
            }
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll(); //grazina array sudaryta visa is eiluciu
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getOrdersCount($search)
    {
        try {
            $query = $this->getSqlQuery("count(*)", $search);
            $stmt = $this->dbConnection->prepare($query);
            if ($search != null) {
                $stmt->bindValue(':search', "%$search%");
            }
            $stmt->execute();
            return $ordersCount = $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    protected function getSqlQuery($selectCon, $search, $sorting = null, $direction = null, $numOfPage = null, $pageSize = null)
    {
        $limitQuery = "";
        if ($numOfPage != null && $pageSize != null) {
            $offset = ($numOfPage - 1) * $pageSize;
            $limitQuery = "LIMIT $offset,$pageSize";
        }
        $sortingQuery = "";
        if ($sorting != null && $direction != null) {
            $columnMAP = array("id" => 'Id', 'name' => 'Name', 'lastname' => 'Last_Name', 'email' => 'Email', 'number' => 'Number', 'address' => 'Address');
            $sorting = $columnMAP[$sorting];
            $directionMAP = array('desc' => 'DESC', 'asc' => 'ASC');
            $direction = $directionMAP[$direction];
            $sortingQuery = "ORDER BY $sorting $direction";
        }
        $where = "";
        if ($search != null) {
            $where = "where Name like :search or Last_name like :search or Email like :search or Address like :search";
        }
        $query = "SELECT $selectCon FROM orders $where $sortingQuery $limitQuery";
        return $query;
    }
}
