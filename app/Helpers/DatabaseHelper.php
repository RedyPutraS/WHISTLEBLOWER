<?php

namespace App\Helpers;

define('DBUSER', 'root');
define('DBPASS', '');
define('SERVERHOST', 'localhost');

class MySql
{
    private $dbc;
    private $user;
    private $pass;
    private $dbname;
    private $host;

    function __construct($host = "localhost", $dbname = "your_databse_name_here", $user = "your_username", $pass = "your_password")
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->host = $host;
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try {
            $this->dbc = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8', $user, $pass, $opt);
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
            echo "There was a problem with connection to db check credenctials";
        }
    }


    public function backup_tables($tables = '*')
    {
        $host = $this->host;
        $user = $this->user;
        $pass = $this->pass;
        $dbname = $this->dbname;
        $data = "";
        if ($tables == '*') {
            $tables = array();
            $result = $this->dbc->prepare('SHOW TABLES');
            $result->execute();
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }
        }
        else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
        foreach ($tables as $table) {
            $resultcount = $this->dbc->prepare('SELECT count(*) FROM ' . $table);
            $resultcount->execute();
            $num_fields = $resultcount->fetch(PDO::FETCH_NUM);
            $num_fields = $num_fields[0];

            $result = $this->dbc->prepare('SELECT * FROM ' . $table);
            $result->execute();
            $data .= 'DROP TABLE ' . $table . ';';

            $result2 = $this->dbc->prepare('SHOW CREATE TABLE ' . $table);
            $result2->execute();
            $row2 = $result2->fetch(PDO::FETCH_NUM);
            $data .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = $result->fetch(PDO::FETCH_NUM)) {
                    $data .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $data .= '"' . $row[$j] . '"';
                        } else {
                            $data .= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $data .= ',';
                        }
                    }
                    $data .= ");\n";
                }
            }
            $data .= "\n\n\n";
        }
        $filename = 'db-backup-' . time() . '-' . (implode(",", $tables)) . '.sql';
        $this->writeUTF8filename($filename, $data);
    }

    public function writeUTF8filename($filenamename, $content) {
        $f = fopen($filenamename, "w+");
        fwrite($f, pack("CCC", 0xef, 0xbb, 0xbf));
        fwrite($f, $content);
        fclose($f);
    }

    public function recoverDB($file_to_load)
    {
        echo "write some code to load and proccedd .sql file in here ...";
    }

    public function closeConnection()
    {
        $this->dbc = null;
    }
}