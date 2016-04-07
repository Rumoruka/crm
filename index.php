<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>crm</title>
</head>
<body>
    <div class="wrapper">
        <form method="post" action="http://api-spotplatform.plustocks.com/api">
            <input type="hidden" name="api_username" value="ExpertAffNetwork"/>
            <input type="hidden" name="api_password" value="m9IvX94tYk"/>
            <input type="hidden" name="MODULE" value="Customer"/>
            <input type="hidden" name="COMMAND" value="add"/><br/>
            <input type="text" name="FirstName" id="FirstName"/><label for="FirstName">First Name</label><br/>
            <input type="text" name="LastName" id="LastName"/><label for="LastName">Last Name</label><br/>
            <input type="text" name="email" id="email"/><label for="email">Email Adress</label><br/>
            <input type="text" name="password" id="password"/><label for="password">Password</label><br/>
            <input type="hidden" name="campaignId" id="campaignId" value="67"/>
            <select name="Country" id="Country">
                <?php include_once("exel.php"); ?>
            </select>
            <br/>
            <input type="text" name="Phone" id="Phone"/><label for="Phone">Phone</label><br/>
            <input type="text" name="subCampaign" id="subCampaign"/><label for="subCampaign ">Sub Campaign</label><br/>
            <input type="text" name="currency" id="currency"/><label for="currency">Currency</label><br/>
            <select name="isLead" id="isLead">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select><label for="isLead">Is Lead?</label><br/>
            <input type="submit" value="Submit"/>
        </form>
    </div>
</body>
</html>