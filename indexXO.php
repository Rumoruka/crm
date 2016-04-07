<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>crm</title>
</head>
<body>
    <div class="wrapper">
        <form method="post" action="serverSideXO.php">
            <input type="hidden" name="affiliateUserName" value="expertaffnetwor"/>
            <input type="hidden" name="affiliatePassword" value="DwqH1l5x"/>
            <input type="hidden" name="trackingCode" value="2215"/>
            <input type="text" name="userName" id="userName"/><label for="userName">Username</label><br/>
            <input type="text" name="firstName" id="firstName"/><label for="firstName">First Name</label><br/>
            <input type="text" name="lastName" id="lastName"/><label for="lastName">Last Name</label><br/>
            <input type="text" name="email" id="email"/><label for="email">Email Adress</label><br/>
            <input type="text" name="phoneNumber" id="phoneNumber"/><label for="phoneNumber">Phone Number</label><br/>
            <select name="countryId" id="countryId">
                <?php include_once("exel2.php"); ?>
            </select><label for="phoneNumber">Country</label><br/>
            <select name="currencyId" id="currencyId">
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
            </select><label for="currencyId">Currency</label><br/>
            <input type="text" name="Param1" id="Param1"/><label for="Param1">Sub Campaign</label><br/>
            <input type="submit" value="Submit"/>
        </form>
    </div>
</body>
</html>