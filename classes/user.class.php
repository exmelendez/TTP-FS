<?php

class User extends Sql {

    private $sql;
    private $userId;
    private $acctBal;

    private $stmtArr =
        array(
            'type' => null,
            'selectOption' => null,
            'tableName' => null,
            'updateVal' => null,
            'whereVals' => null,
            'insertVals' => null,
            'groupCol' => null,
            'orderCol' => null,
            'sortOrder' => null
        );

    public function __construct() {
        $this->sql = new Sql();
    }

    public function ableToPurchase($qty, $symPrice) {
        $totalPurchaseCost = $qty * $symPrice;
        $buyValid = false;

        if($totalPurchaseCost < $this->getAcctBalance()) {
            $buyValid = true;
        }

        return $buyValid;
    }

    public function closeDbConnection() {
        $this->sql->closeDbConn();
        $this->sql = null;
        $this->userId = null;
    }

    public function createAcct($fName, $lName, $email, $pwd) {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'users';
        $this->stmtArr['whereVals']['email'] = $email;

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        $acctCreateSuccess = false;

        if($this->sql->dbValExist()) {
            return $acctCreateSuccess;
        } else {
            $acctCreateSuccess = true;
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

            $this->stmtArr['type'] = 'insert';
            $this->stmtArr['tableName'] = 'users';
            $this->stmtArr['insertVals'] = array(
                'firstName' => $fName,
                'lastName' => $lName,
                'email' => $email,
                'pwd' => $hashedPwd
            );

            $this->sql->setStmt($this->stmtArr);
            $this->resetStmtArr();
            $this->sql->executeQuery();

            $this->stmtArr['type'] = 'select';
            $this->stmtArr['selectOption'] = '*';
            $this->stmtArr['tableName'] = 'users';
            $this->stmtArr['whereVals']['email'] = $email;

            $this->sql->setStmt($this->stmtArr);
            $this->resetStmtArr();

            $acctInfo = $this->sql->loginValidation($pwd);

            $this->stmtArr['type'] = 'insert';
            $this->stmtArr['tableName'] = 'userBalance';
            $this->stmtArr['insertVals'] = array(
                'userId' => $acctInfo['userId'],
                'balance' => 5000.00
            );

            $this->sql->setStmt($this->stmtArr);
            $this->resetStmtArr();
            $this->sql->executeQuery();

            $this->userId = $acctInfo['userId'];
            $this->recordMoneyTrans('D', 5000.00);

            $this->closeDbConnection();

            return $acctCreateSuccess;
        }
    }

    private function fetchMoneyTransData() {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'moneyTrans';
        $this->stmtArr['whereVals']['userId'] = $this->userId;
        $this->stmtArr['orderCol'] = 'transDate';
        $this->stmtArr['sortOrder'] = 'DESC';

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();

        $data = $this->sql->getTableData();

        $moneyTransVals = array();
        $arrIndex = 0;

        if(sizeof($data) > 0) {
            foreach ($data as $nestArr) {
                foreach ($nestArr as $key => $value) {
                    if($key === 'userId') {
                        $phpdate = strtotime($nestArr['transDate']);
                        $mysqldate = date('m/d/Y', $phpdate);
                        $openTr = "<tr>";
                        $closeTr = "</tr>";
                        $openTd = "<td>";
                        $closeTd = "</td>";
                        $transType;

                        if($nestArr['transType'] == 'D') {
                            $transType = 'Deposit';
                        } else if ($nestArr['transType'] == 'P') {
                            $transType = 'Purchase';
                        }

                        $moneyTransVals[$arrIndex] =
                            $openTr
                            . $openTd . $transType . $closeTd
                            . $openTd . '$' . $nestArr['amount'] . $closeTd
                            . $openTd . $mysqldate . $closeTd
                            . $closeTr;

                        $arrIndex++;
                    }
                }
            }
        }
        return $moneyTransVals;
    }

    private function fetchStkTransData() {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'stockTrans';
        $this->stmtArr['whereVals']['userId'] = $this->userId;
        $this->stmtArr['orderCol'] = 'transDate';
        $this->stmtArr['sortOrder'] = 'DESC';

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();

        $data = $this->sql->getTableData();

        $stkTransVals = array();
        $arrIndex = 0;

        if(sizeof($data) > 0) {
            foreach ($data as $nestArr) {
                foreach ($nestArr as $key => $value) {
                    if($key === 'symbol') {
                        $phpdate = strtotime($nestArr['transDate']);
                        $mysqldate = date('m/d/Y', $phpdate);
                        $openTr = "<tr>";
                        $closeTr = "</tr>";
                        $openTd = "<td>";
                        $closeTd = "</td>";
                        $transType;

                        if($nestArr['transType'] == 'B') {
                            $transType = 'Buy';
                        } else if ($nestArr['transType'] == 'S') {
                            $transType = 'Sell';
                        }

                        $stkTransVals[$arrIndex] =
                            $openTr
                            . $openTd . $transType . $closeTd
                            . $openTd . $nestArr['symbol'] . $closeTd
                            . $openTd . $nestArr['qty'] . $closeTd
                            . $openTd . '$' . $nestArr['indivCost'] . $closeTd
                            . $openTd . '$' . $nestArr['totalCost'] . $closeTd
                            . $openTd . $mysqldate . $closeTd
                            . $closeTr;

                        $arrIndex++;
                    }
                }
            }
        }
        return $stkTransVals;
    }

    public function getAcctBalance() {
        return $this->acctBal;
    }

    private function getOwnedStockList() {

        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'stocks';
        $this->stmtArr['whereVals']['userId'] = $this->userId;
        $this->stmtArr['groupCol'] = 'symbol';
        $this->stmtArr['sortOrder'] = 'ASC';

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();

        return $this->sql->getTableData();
    }

    public function getPortfolioReport($reportType) {
        $stockData = $this->getOwnedStockList();
        $stkPortfolioValue = 0;
        $portStkVals = array();
        $arrIndex = 0;

        if(sizeof($stockData) > 0) {

            $mainDivOpenTag = '<div class="ind-stock-cont">';
            $stkInfoCont = '<div class="stock-info">';
            $firstP = '<p class="stk-dat stk-space-top stk-space">';
            $lastP = '<p class="stk-dat stk-space-bot stk-space">';

            $sideBarColor = "status-neu-color";
            $symbolValueColor = "val-color-status";

            $closePSpecial = '</p>';
            $closePTag = '</p>';
            $closeDivTag = '</div>';

            foreach($stockData as $stock) {
                $sharesText = " Share";
                $apiData = $this->getStockData($stock['symbol']);

                $stockCurrentPrice = $apiData['latestPrice'];

                $stockCurrentVal = $stockCurrentPrice * $stock['qty'];
                $stkPortfolioValue += $stockCurrentVal;

                $stockOpenDayVal = $apiData['open'];

                if($stockCurrentPrice < $stockOpenDayVal) {
                    $sideBarColor = "status-down-color";
                    $symbolValueColor = "val-color-status-down";
                    $closePSpecial = '<i class="fas fa-long-arrow-alt-down"></i>
                    </p>';

                } else if ($stockCurrentPrice > $stockOpenDayVal) {
                    $sideBarColor = "status-up-color";
                    $symbolValueColor = "val-color-status-up";
                    $closePSpecial = '<i class="fas fa-long-arrow-alt-up"></i>
                    </p>';
                }

                if($stock['qty'] > 1) {
                    $sharesText .= 's';
                }
                
                $portStkVals[$arrIndex] = "" . $mainDivOpenTag . '<div class="status-color-div ' . $sideBarColor . '">' . $closeDivTag . $stkInfoCont . $firstP . $stock['symbol'] . $closePTag . '<p class="' . $symbolValueColor . '">$' . $stockCurrentVal . ' ' .$closePSpecial . $lastP . $stock['qty'] . $sharesText . $closePTag . $closeDivTag . $closeDivTag . "";

                $arrIndex++;
            }
        }

        switch ($reportType) {
            case 'body':
                    return $portStkVals;

            case 'value':
                $stkPortfolioValue += $this->getAcctBalance();
                return $stkPortfolioValue;
           
        }
    }

    public function getStockData($stockSymbol) {
        $call = "https://cloud.iexapis.com/stable/stock/$stockSymbol/quote?token=pk_0b24b9d449db422194decd95feda86d0";
    
        $content = file_get_contents($call);

        /*****
         * 
         * $data below returns data from JSON API. There is the option for values like $data['companyName'], $data['symbol'], $data['latestPrice'], $data['open'] (this is the opening price), etc.
         */
        $data = json_decode($content, true);
        
        if($http_response_header[0] == "HTTP/1.1 200 OK") {
            return $data;
        } else {
            return "symbol not found";
        }
    }

    public function getStocktrans() {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'stockTrans';
        $this->stmtArr['whereVals']['userId'] = $this->userId;
        $this->stmtArr['orderCol'] = 'transDate';
        $this->stmtArr['sortOrder'] = 'DESC';

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        
        return $this->sql->getTableData();
    }

    public function getTransReport($type) {
        switch ($type) {
            case 'stock':
                return $this->fetchStkTransData();
            
            case 'money':
                return $this->fetchMoneyTransData();
        }
    }

    public function loginProcess($id) {
        $this->setUserId($id);
        $this->setAcctBalance();
    }

    public function purchaseStock($symbol, $qty, $symIndCost) {
        $purchCost = $qty * $symIndCost;
        $stockAlreadyOwned = $this->stockOwnCheck($symbol);

        if($stockAlreadyOwned) {
            $this->stmtArr['type'] = 'select';
            $this->stmtArr['selectOption'] = 'qty';
            $this->stmtArr['tableName'] = 'stocks';
            $this->stmtArr['whereVals']['userId'] = $this->userId;
            $this->stmtArr['whereVals']['symbol'] = $symbol;

            $this->sql->setStmt($this->stmtArr);
            $this->resetStmtArr();

            $queryData = $this->sql->getTableData();
            $numOfCurrentStks = $queryData[0]['qty'];

            $this->stmtArr['type'] = 'update';
            $this->stmtArr['tableName'] = 'stocks';
            $this->stmtArr['updateVal']['qty'] = $numOfCurrentStks + $qty;
            $this->stmtArr['whereVals']['userId'] = $this->userId;
            $this->stmtArr['whereVals']['symbol'] = $symbol;

        } else {
            $this->stmtArr['type'] = 'insert';
            $this->stmtArr['tableName'] = 'stocks';
            $this->stmtArr['insertVals'] = array(
                'userId' => $this->userId,
                'symbol' => $symbol,
                'qty' => $qty
            );
        }
        
        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        $this->sql->executeQuery();

        $this->recordStockTrans('B', $symbol, $qty, $symIndCost, $purchCost);
        $this->updateAcctBalance($purchCost, 'sub');
    }

    private function recordMoneyTrans($type, $amount) {

        if($type == 'D' || $type == 'P') {

            $this->stmtArr['type'] = 'insert';
            $this->stmtArr['tableName'] = 'moneyTrans';
            $this->stmtArr['insertVals'] = array(
                'userId' => $this->userId,
                'transType' => $type,
                'amount' => $amount
            );

            $this->sql->setStmt($this->stmtArr);
            $this->resetStmtArr();
            $this->sql->executeQuery();

        } else {
            throw new \Exception("invalid money transaction type entered. '" . $type . "' entered as value. Only 'D' or 'P' allowed.");
        }
    }

    private function recordStockTrans($type, $symbol, $qty, $stkIndCost, $totalCost) {

            if($type == 'B' || $type == 'S') {

                $this->stmtArr['type'] = 'insert';
                $this->stmtArr['tableName'] = 'stockTrans';
                $this->stmtArr['insertVals'] = array(
                    'userId' => $this->userId,
                    'symbol' => $symbol,
                    'qty' => $qty,
                    'transType' => $type,
                    'totalCost' => $totalCost,
                    'indivCost' => $stkIndCost
                );
    
                $this->sql->setStmt($this->stmtArr);
                $this->resetStmtArr();
                $this->sql->executeQuery();

            } else {
                throw new \Exception("invalid stock transaction type entered. '" . $type . "' entered as value. Only 'B' or 'S' allowed.");
            }
    }

    private function resetStmtArr() {
        $this->stmtArr['type'] = null;
        $this->stmtArr['selectOption'] = null;
        $this->stmtArr['tableName'] = null;
        $this->stmtArr['updateVal'] = null;
        $this->stmtArr['whereVals'] = null;
        $this->stmtArr['insertVals'] = null;
        $this->stmtArr['groupCol'] = null;
        $this->stmtArr['orderCol'] = null;
        $this->stmtArr['sortOrder'] = null;
    }

    private function setAcctBalance() {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'userBalance';
        $this->stmtArr['whereVals']['userId'] = $this->userId;

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        $returnVal = $this->sql->getTableData();

        $this->acctBal = $returnVal[0]['balance'];
    }

    private function setUserId($id) {
        $userId = intval($id);
        $this->userId = $userId;
    }

    public function stockOwnCheck($symbol) {
        $this->stmtArr['type'] = 'select';
        $this->stmtArr['selectOption'] = '*';
        $this->stmtArr['tableName'] = 'stocks';
        $this->stmtArr['whereVals']['userId'] = $this->userId;
        $this->stmtArr['whereVals']['symbol'] = $symbol;

        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();

        return $this->sql->dbValExist();
    }

    private function updateAcctBalance($amount, $updateType) {
        $balance = $this->getAcctBalance();

        $this->stmtArr['type'] = 'update';
        $this->stmtArr['tableName'] = 'userBalance';
        $this->stmtArr['whereVals']['userId'] = $this->userId;
        $newBalance;

        switch ($updateType) {
            case 'add':
                $newBalance = $balance + $amount;
                $this->stmtArr['updateVal']['balance'] = $newBalance;
                break;

            case 'sub':
                $newBalance = $balance - $amount;
                $this->stmtArr['updateVal']['balance'] = $newBalance;
                break;
        }

        $this->acctBal = $newBalance;
        $this->sql->setStmt($this->stmtArr);
        $this->resetStmtArr();
        $this->sql->executeQuery();

        switch ($updateType) {
            case 'add':
                $this->recordMoneyTrans('D', $amount);
                break;

            case 'sub':
                $this->recordMoneyTrans('P', $amount);
                break;
        }
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
    
}