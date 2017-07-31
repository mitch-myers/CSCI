<?php
    // The SacntionQuoteGUI class provides user interaction
    class SanctionQuoteGUI
    {
        public function displayQuote($controller, $quoteList)
        {
            // display HTML page
            print ('<title>Sanction a Quote</title>
                    </head>
                    <body>
                    <form action="sanctionQuote.php" method="POST">
                    <h2>Sanction a Quote</h2>
            ');
        
            $quotesByID = $controller->getFinalizedQuote($quoteList);

            // display a dropdown box with a default selection
            print ('Select a finalized Quote: 
                    <select name="quoteId">
                    <option value="" disabled selected>Quote by ID</option>
            ');

            // diplay quotes by ID in the drop down box
            foreach ($quotesByID as $row)
            {
                echo "<option value='".$row["quoteId"]. "'>" .$row["quoteId"]."</option>";
            }
        
            // display submit button
            print ('</select>
                    <input type="submit" value="Submit">
                    <br><br>
            ');

            // retrieves user selection from dropdown
            $_POST["quoteId"];
            $db=connect("courses","z981329","z981329","1979Jul29");

            // uses the selected ID number to query the quote database
            $qVal = $_POST["quoteId"];
    	    $sqlA = "SELECT * FROM Quote WHERE quoteId = '$qVal';";
    	    $resultA = $db->query($sqlA);

            // retrieve line items from quote database
            $sqlB = "SELECT * FROM LineItem WHERE quoteId = '$qVal';";
    	    $resultB = $db->query($sqlB);

            // displays quote information to the user based on quote ID number
    	    if (isset($_POST["quoteId"]))
            {
			    while(($rowA = $resultA->fetch()) != NULL)
                {
                    echo "<h3>Quote Information</h3><hr>";
                    echo "<b>Sales Associate: </b>" .$rowA["salesAssociate"]. "<br>";
                    echo "<b>Quote ID: </b>" .$rowA["quoteId"]. "<br><br>";
                    echo "<h3>Customer Information</h3><hr>";
       		        echo "<b>Customer Name: </b>" .$rowA["customerName"]. "<br>";
       		        echo "<b>Customer Address: </b>" .$rowA["customerAddress"]. "<br>";
                    echo "<b>Customer City: </b>" .$rowA["customerCity"]. "<br>";
                    echo "<b>Customer Email: </b>" .$rowA["customerEmail"]. "<br><br>";
                    echo "<h3>Customer Items</h3><hr>";
                    echo "<table border=0 width=75%><tr>";
       			    echo "<th align=left>Description</th>";
       			    echo "<th align=left>Price</th>";
                    echo "<th align=left>Secret Notes</th></tr>";

                    while(($rowB = $resultB->fetch()) != NULL)
                    {
                        echo "<tr><td>".$rowB["description"]."</td>";
                        echo "<td>".$rowB["price"]."</td>";
                        echo "<td>".$rowB["secretNote"]."</td></tr>";
                    } // end while for resultB
       		    } // end while for resultA
		    } // end if
        } // end function
    } // end class

?>