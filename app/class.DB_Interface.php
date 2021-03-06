<?php

error_reporting(E_ALL);

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * Short description of class DB_Interface
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 */
class DB_Interface
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd : 
    // --- ATTRIBUTES ---
    private $host = null;
    private $username = null;
    private $password = null;
    private $db_name = null;
    private $pdo = null;
    private $stmt = null;
    // --- OPERATIONS ---
    /**
     * Short description of method _construct
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String name
     * @param  String password
     * @return mixed
     */
    public function __construct($host, $username, $password, $db_name)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;
        $this->pd = null;
        try {
            $this->pd = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
            $this->pd->exec("SET NAMES 'utf8' COLLATE 'utf8_bin'");
            $this->pd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "object created";
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }
    public function __destructor()
    {
        $this->pd = null;
        $this->stmt = null;
    }
    /**
     * Short description of method executeQuery
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String query
     * @return Table
     */
    public function executeQuery($query)
    {
        //not that functional yet
        $returnValue = null;
        $this->stmt = $this->pd->prepare($query);
        $returnValue = $this->stmt->execute();
        return $returnValue;
    }
    public function insertUser($name, $lastName, $password, $email, $tel_number)
    {
        try {
            $this->stmt = $this->pd->prepare("INSERT INTO user (name, last_name, password, email, tel_number) VALUES (:name, :last_name, :password, :email, :tel_number)");
            $this->stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $this->stmt->bindParam(":last_name", $lastName, PDO::PARAM_STR);
            $this->stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $this->stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $this->stmt->bindParam(":tel_number", $tel_number, PDO::PARAM_INT);
            return $this->stmt->execute();
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
    public function deleteUser($id)
    {
        try {
            $this->stmt = $this->pd->prepare("DELETE FROM user WHERE user_id = :user_id");
            $this->stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
            return $this->stmt->execute();
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
    public function getUserData($email, $password) {
        try {
            $this->stmt = $this->pd->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
            $this->stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $this->stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $this->stmt->execute();
			return $this->stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
	
	public function insertSlot($start, $length, $employee)
    {
        try {
            $this->stmt = $this->pd->prepare("INSERT INTO time_slot (start, length, employee) VALUES (:start, :length, :employee)");
            $this->stmt->bindParam(":start", strtotime(date("Y-m-d H:i:s")), PDO::PARAM_STR);
            $this->stmt->bindParam(":length", $length, PDO::PARAM_INT);
            $this->stmt->bindParam(":employee", $employee, PDO::PARAM_INT);
            return $this->stmt->execute();
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }
	
	
    /*public function insertProcedure()
    {
    
    }*/
} /* end of class DB_Interface */

?>