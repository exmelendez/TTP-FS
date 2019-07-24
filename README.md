# IEX/API Mock Web Portfolio Stock Site

## Goal
Create a web based stock portfolio app using the free [IEX API](https://iextrading.com/developer/).

## Languages/Technology Used
* HTML
* CSS
* JavaScript
* PHP
* SQL/PHP MyAdmin

## Feature List
* PHP OOP Implementation with a focus on DRY code
* Ability to register account with name, email and password
* JS Dynamic form used for either login or registration
* Email/password authentication, including page redirection if not logged in
* API use to fetch current stock rate(s) and other current stock info
* User input used to check validity of stock and purchase ability
* Ability to write/Read and update DB data
* User color coded front end stock DIV(s) with red as low and green as high
* User readable presentation of DB data, such as transactions

# Screen Shots

**Login / Index.php**

![Index/Login Form](https://i.imgur.com/VAh1KSC.png)

**Register / Index.php**

![Index/Register Form](https://i.imgur.com/xL3ethJ.png)

**Portfolio.php**

![Portfolio Page](https://i.imgur.com/OFQkI7K.png)

**Stock Search - IEX API Call / Portfolio.php**

![Portfolio/Stock Purchase Form](https://i.imgur.com/754BXJD.png)

**Stock Purchase Confirm - Pre PHP Submit / Portfolio.php**

![Stock Purchase Confirm](https://i.imgur.com/hvTPcvt.png)

**Transactions.php**

![Transaction Page](https://i.imgur.com/NNgHsrd.png)

**Monetary Acct Transactions Table - Transactions.php**

![Transaction Page](https://i.imgur.com/OycaSYl.png)

## Error Checks / Notifications

### Registration
When a user registers they are presented with a success message informing them they can now login.

![Successful Registration](https://i.imgur.com/nfU2LwE.png)

### Invalid Login
If a user attempts to login with invalid credentials they are presented with a message on the index page
![Invalid Login](https://i.imgur.com/s8CPMMg.png)

### Portfolio Empty Notification
If a user has signed up or they have no made any purchases they will be presented with this message on both the portfolio page and the stock transaction page.

![No Stks on Portfolio Page](https://i.imgur.com/m64R9nV.png)

![No Stks on Transaction Page](https://i.imgur.com/6KKPG4y.png)

### Invalid Stock Symbol
When a user is attempting to purchase or view a stock's price if they type in a symbol that is not found or valid they will be notified of this error and the form will not allow them to proceed.
![Invalid Symbol/Not Found](https://i.imgur.com/e97IC3F.png)

### Modal Notifications
When attempting to make a purchase a user will be presented with a popup modal in one of two instances. One being a succeful purchase, the other being when the balance cannot cover a purchase amount.

![Successful Purchase Modal](https://i.imgur.com/cUdjzgO.png)

![Insufficient Funds Modal](https://i.imgur.com/MnbdE58.png)


# NOTES/Updates

Future updates may includes things like . . .
* a way to sell stocks back
* implementing JS Node or other method to remove API token from JS
* displaying purchase modal to confirm purchase & prevent fraudulent code/injection