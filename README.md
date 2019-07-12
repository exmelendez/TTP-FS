# Currently in the process of re-doing entire project using OOP.

## Database Connection Class
```php
class DbConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $dbConnection;

    protected function connect() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "iex";

        try {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbConnection = $pdo;

        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
    }

    protected function getDbConn() {
        if(isset($this->dbConnection)) {
            return $this->dbConnection;
        }
        else {
            return "error";
        }
    }

    protected function closeConn() {
        $this->dbConnection = null;
    }
}
```

## SQL Class
```php
class SqlOps extends DbConnection {
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
        $dbTable = $stmtArr['tableName'];

        switch ($stmtArr['type']) {
            case 'insert':
                $stmt = "INSERT INTO "  .$dbTable. " (";

                foreach($stmtArr['insertVals'] as $key => $value) {
                    if($value === end($stmtArr['insertVals'])) {
                        $stmt .= $key .") VALUES (";
                    } else {
                        $stmt .= $key .", ";
                    }
                }

                foreach($stmtArr['insertVals'] as $value) {
                    if($value === end($stmtArr['insertVals'])) {
                        $stmt .= $this->valueFormatter($value).");";
                    } else {
                        $stmt .= $this->valueFormatter($value).", ";
                    }
                }
                break;

            case 'select':
                $stmt = "SELECT " .$stmtArr['selectOption']. " FROM " .$dbTable. " WHERE ";

                foreach($stmtArr['whereVals'] as $key => $value) {
                    if($value === end($stmtArr['whereVals'])) {

                        $stmt .= $key." = ".$this->valueFormatter($value);

                    } else {
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

                $stmt = "UPDATE " .$dbTable. " SET ";

                foreach($stmtArr['updateVals'] as $key => $value) {

                    $stmt .= $key ." = ".$value;
                }

                $stmt .= " WHERE ";
                
                foreach($stmtArr['whereVals'] as $key => $value) {
                    if($value === end($stmtArr['whereVals'])) {

                        $stmt .= $key." = ".$this->valueFormatter($value).";";

                    } else {
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

    protected function getStmt() {
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
                'userId' => null
            );

        if($sql->rowCount() === 1) {
            $acctInfo['acctFound'] = true;
            $row = $sql->fetch();
            $pwdCheck = password_verify($pwd, $row['pwd']);

            if($pwdCheck) {
                $acctInfo['acctPwdValid'] = true;
                $acctInfo['userId'] = $row['primeId'];
            }
        }
        
        $this->resetStmt();
        return $acctInfo;
    }

    protected function userExist() {
        // print_r($this->getStmt());
        $testStmt = "SELECT * FROM users WHERE email = 'eman@aol.com';";
        $sql = $this->getDbConn()->query($testStmt);
        $acctFound = false;

        if($sql->rowCount() === 1) {
            $acctFound = true;
        }

        $this->resetStmt();
        return $acctFound;
    }

    protected function insert() {
        $sql = $this->getDbConn()->query($this->getStmt());
        $this->resetStmt();
    }
}
```

## User Class
```php
class User extends SqlOps {

    private $sql;

    private $stmtArr =
        array(
            'type' => null,
            'selectOption' => null,
            'tableName' => null,
            'updateVals' => null,
            'whereVals' => null,
            'insertVals' => null,
            'groupCol' => null,
            'orderCol' => null,
            'sortOrder' => null
        );

    public function __construct() {
        $this->sql = new SqlOps();
    }

    private function resetStmtArr() {
        $this->stmtArr['type'] = null;
        $this->stmtArr['selectOption'] = null;
        $this->stmtArr['tableName'] = null;
        $this->stmtArr['updateVals'] = null;
        $this->stmtArr['whereVals'] = null;
        $this->stmtArr['insertVals'] = null;
        $this->stmtArr['groupCol'] = null;
        $this->stmtArr['orderCol'] = null;
        $this->stmtArr['sortOrder'] = null;
    }

    public function verifyAcct($email, $pwd) {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'users';
        $this->stmtArr['whereVals']['email'] = $email;

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        
        return $this->sql->loginValidation($pwd);
    }

    public function createAcct($name, $email, $pwd) {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'users';
        $this->stmtArr['whereVals']['email'] = $email;

        print_r($this->stmtArr);

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        $acctCreateSuccess = false;

        if($this->userExist()) {
            return $acctCreateSuccess;
        } else {
            $acctCreateSuccess = true;
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

            $this->stmtArr['type'] = 'insert';
            $this->stmtArr['tableName'] = 'users';
            $this->stmtArr['insertVals'] = array(
                'fullName' => $name,
                'email' => $email,
                'pwd' => $hashedPwd
            );

            $this->sql->setStmt($this->stmtArr);
            $this->resetStmtArr();
            $this->sql->insert();

            return $acctCreateSuccess;
        }
    }

    public function closeDbConnection() {
        $this->sql->closeDbConn();
    }
   
}
```
