<?php

class Sql extends DbConnection {
    private $stmt;

    protected function __construct() {
        $this->connect();
    }

    protected function closeDbConn() {
        $this->resetStmt();
        $this->closeConn();
    }

    protected function setStmt($stmtArr) {
        $stmt;
        $index = 0;
        $dbTable = $stmtArr['tableName'];

        switch ($stmtArr['type']) {
            case 'insert':
                $arrLength = count($stmtArr['insertVals']);

                $stmt = "INSERT INTO "  .$dbTable. " (";

                foreach($stmtArr['insertVals'] as $key => $value) {
                    if($index === $arrLength - 1) {
                        $stmt .= $key .") VALUES (";
                    } else {
                        $index++;
                        $stmt .= $key .", ";
                    }
                }

                $index = 0;
                
                foreach($stmtArr['insertVals'] as $value) {
                    if($index === $arrLength - 1) {
                        $stmt .= $this->valueFormatter($value).");";
                    } else {
                        $index++;
                        $stmt .= $this->valueFormatter($value).", ";
                    }
                }
                
                break;

            case 'select':
                $arrLength = count($stmtArr['whereVals']);

                $stmt = "SELECT " .$stmtArr['selectOption']. " FROM " .$dbTable. " WHERE ";

                foreach($stmtArr['whereVals'] as $key => $value) {
                    if($index === $arrLength - 1) {

                        $stmt .= $key." = ".$this->valueFormatter($value);

                    } else {
                        $index++;
                        $stmt .= $key." = ".$this->valueFormatter($value)." AND ";
                    }
                }

                if($stmtArr['groupCol'] != null) {
                    $stmt .= " GROUP BY " .$stmtArr['groupCol'];
                }

                if($stmtArr['orderCol'] != null) {
                    $stmt .= " ORDER BY " .$stmtArr['orderCol'];
                }

                if($stmtArr['sortOrder'] != null) {
                    $stmt .= " " .$stmtArr['sortOrder'];
                }

                $stmt .= ";";

                break;

            case 'update':
                $arrLength = count($stmtArr['whereVals']);

                $stmt = "UPDATE " .$dbTable. " SET ";

                foreach($stmtArr['updateVal'] as $key => $value) {

                    $stmt .= $key ." = ".$value;
                }

                $stmt .= " WHERE ";
                
                foreach($stmtArr['whereVals'] as $key => $value) {
                    if($index === $arrLength - 1) {

                        $stmt .= $key." = ".$this->valueFormatter($value).";";

                    } else {
                        $index++;
                        $stmt .= $key." = ".$this->valueFormatter($value)." AND ";
                    }
                }
                break;
            
            default:
                return "error";
        }

        $this->stmt = $stmt;
    }

    private function valueFormatter($val) {
        if(gettype($val) == "string") {
            $val = "'".$val."'";
        }
        return $val;
    }

    private function getStmt() {
        return $this->stmt;
    }

    private function resetStmt() {
        $this->stmt = null;
    }

    protected function loginValidation($pwd) {
        $sql = $this->getDbConn()->query($this->getStmt());
        $acctInfo = 
            array(
                'acctFound' => false,
                'acctPwdValid' => false,
                'userId' => null,
                'fName' => null
            );

        if($sql->rowCount() === 1) {
            $acctInfo['acctFound'] = true;
            $row = $sql->fetch();
            $pwdCheck = password_verify($pwd, $row['pwd']);

            if($pwdCheck) {
                $acctInfo['acctPwdValid'] = true;
                $acctInfo['userId'] = $row['primeId'];
                $acctInfo['fName'] = $row['firstName'];
            }
        }
        
        $this->resetStmt();
        return $acctInfo;
    }

    protected function dbValExist() {
        $sql = $this->getDbConn()->query($this->getStmt());
        
        $valFound = false;

        if($sql->rowCount() > 0) {
            $valFound = true;
        }

        $this->resetStmt();
        return $valFound;
    }

    protected function executeQuery() {
        print_r($this->getStmt() . "<BR>");
        $sql = $this->getDbConn()->query($this->getStmt());
        $this->resetStmt();
    }

    protected function getTableData() {
        $sql = $this->getDbConn()->query($this->getStmt());

        if($sql->rowCount() > 0) {
            while($row = $sql->fetch()) {
                $data[] = $row;
            }
            $this->resetStmt();
            return $data;
        }

        $this->resetStmt();
    }
    
}