<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>crm</title>
</head>
<body>
    <div class="wrapper">
        <form method="post" action="http://airsoftltd.com/affiliate/externalSorce/api">
            <input type="hidden" name="key" value="dfg4579jf84257"/>
            <input type="hidden" name="method" value="createLead"/>
            <input type="text" name="first_name" id="first_name"/><label for="first_name">First Name</label><br/>
            <input type="text" name="last_name" id="last_name"/><label for="last_name">Last Name</label><br/>
            <input type="text" name="email_address" id="email_address"/><label for="email_address">Email Adress</label><br/>
            <input type="text" name="phone" id="phone"/><label for="phone">Phone Number</label><br/>
            <select name="countryISO" id="countryISO">
                <?php include_once("exel2.php"); ?>
            </select><label for="countryISO">Country</label><br/>
            <select name="currency" id="currency">
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
            </select><label for="currency">Currency</label><br/>
            <input type="text" name="custom_refer" id="custom_refer"/><label for="custom_refer">custom_refer</label><br/>
            <input type="text" name="campaign_id" id="campaign_id"/><label for="campaign_id">campaign_id</label><br/>
            <input type="text" name="campaign_keyword" id="campaign_keyword"/><label for="campaign_keyword">campaign_keyword</label><br/>
            <select name="currency" id="currency">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select><label for="is_lead_only">is_lead_only</label><br/>
            <input type="text" name="comment" id="comment"/><label for="comment">comment</label><br/>
            <input type="submit" value="Submit"/>
        </form>
    </div>
</body>
</html>