<?php
    //class used to display to the user
    class CreatePurchaseOrderGUI
    {
        //will hold an instance to the controller
        var $controller;

        /*******************************************************************
            FUNCTION:   CreatePurchaseOrderGUI::__construct
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      To create an instance of the controller when the
                        interface is created
        *******************************************************************/
        public function __construct()
        {
            $this->controller=new ManagePurchaseOrder;

        }

        /*******************************************************************
            FUNCTION:   CreatePurchaseOrderGUI::chooseQuote
            ARGUMENTS:  none
            RETURNS:    none
            USAGE:      To display the sactioned quotes
        *******************************************************************/
        public function chooseQuote()
        {
            //get the current sactioned quotes
            $list=$this->controller->getSanctionedQuotes();

            //html
            echo "<title>Create PO</title>";
            echo "</head>";
            echo "<body>";
            echo "Select a sactioned quote from the dropdown<br>";
            echo "<form method=POST>";
            echo "<select name='quoteId'>";
            foreach($list as $row)
                echo "<option value=$row[quoteId]>$row[quoteId]-$row[customerName]</option>";
            echo "</select>";
            echo "<input type='submit' name='picked' value='choose'>";
            echo "</form>";
        }

        /*******************************************************************
            FUNCTION:   CreatePurchaseOrderGUI::displayQuote
            ARGUMENTS:  quoteId: unique id number of the quote
            RETURNS:    none
            USAGE:      To display the quote information
        *******************************************************************/
        public function displayQuote($quoteId)
        {
            //gets the information of the quote
            $quote=$this->controller->getQuote($quoteId);

            //html
            echo "<title>Quote Information</title>";
            echo "</head>";
            echo "<body>";
            echo "Customer: ".$quote[customerName]."<br>";
            echo "Street: ".$quote[customerAddress]."<br>";
            echo "City: ".$quote[customerCity]."<br>";
            echo "Email: ".$quote[customerEmail]."<br>";
            echo "Sales Associate: ".$quote[salesAssociate]."<br>";
            echo "<hr>";
            echo "<table width=100%>";
            echo "<tr><th>Description</th><th>Price</th><th>Secert Note</th></tr>";

            //gets the line items attached to the quote
            $lines=$this->controller->getLineItems($quoteId);
            foreach($lines as $line)
            {
                echo "<tr><td>$line[description]</td><td>$$line[price]</td><td>$line[secretNote]</td></tr>";
            }
            echo "</table>";
            echo "Current Total: $".$quote[currentPrice];    
            echo "<hr>";
            echo "<form method=POST>";
            echo "<table>";
            echo "<input type='hidden' name='quoteId' value='$quoteId'>";
            echo "<tr><th>Final discount</th></tr>";
            echo "<tr><td>Dollor amount:</td><td>$<input type='text' name='amount'></td></tr>";
            echo "<tr><td>Percent amount:</td><td><input type='text' name='percent'>%</td></tr>";
            echo "</table>";
            echo "<input type='submit' name='update' value='Create PO'>";
            echo "</form>";        
        }

        /*******************************************************************
            FUNCTION:   CreatePurchaseOrderGUI::createPurchaseOrder
            ARGUMENTS:  $quoteId: unique quote number
                        $amount: the amount to be discounted
                        $percent: the percentage
            RETURNS:    none
            USAGE:      To display that the email is sent after the Po is
                        created
        *******************************************************************/
        public function createPurchaseOrder($quoteId,$amount,$percent)
        {
            //gets the quote info
            $quote=$this->controller->getQuote($quoteId);

            //gets the price and applies the discount
            $price=$quote[currentPrice];
            $price=$price-$amount;
            $price=$price-$price*$percent/100;
            
            //create the PO
            $this->controller->createPurchaseOrder($quoteId,$price);

            //html
            echo "<title>Email Sent</title>";
            echo "</head>";
            echo "<body>";
            echo "Email has been sent<br>";
            echo "<a href='createPO.php'>Return</a>";
        }
    }
?>
