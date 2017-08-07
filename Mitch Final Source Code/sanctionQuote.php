<?php session_start();?>

<!-- SanctionQuoteGUI Driver Page -->

<!DOCTYPE html>
<HTML>
<head>
    <meta charset="utf-8">

	<?php
        // files required for operation
        require "QuoteStore.php";
        require "ManageQuote.php";
        require "SanctionQuoteGUI.php";
        require "dbconnect.php";

        // create new instance of the classes
        $quoteStore = new QuoteStore;
        $controller = new ManageQuote;   
        $interface=new SanctionQuoteGUI;

        // display the quote selection interface
        $interface->displayQuote($controller, $quoteStore); 

        // if a quote is selected, display the quote and editing functions
        if($_SERVER[REQUEST_METHOD] == "POST")
        {
            if(isset($_POST[viewQuote]))
            {
                $interface->viewQuote($controller, $quoteStore);
                $interface->calculatePrice($controller,$_SESSION[quoteId]);
                $interface->addLineItems($quoteStore);
                $interface->editLineItems($quoteStore);
                $interface->removeLineItems($quoteStore);
                $interface->addSecretNote($quoteStore);
                $interface->editSecretNote($quoteStore);
                $interface->calculateDiscounts($quoteStore);
                $interface->calculateFinalPrice($controller,$_SESSION[quoteId]);
                $interface->updateQuote($controller, $quoteStore);

            } // end if

            // On Submit: Send the information to the function for processing
            if(isset($_POST[submitLineItems]))
                $quoteStore->addLineItems($_SESSION[quoteId], $_POST[addDescription], $_POST[addPrice]);

            if(isset($_POST[editLineItems]))
                $quoteStore->editLineItems($_SESSION[quoteId], $_POST[lineId], $_POST[editDescription], $_POST[editPrice]);

            if(isset($_POST[removeLineItems]))
                $quoteStore->removeLineItems($_SESSION[quoteId], $_POST[lineId]);

            if(isset($_POST[submitSecretNote]))
                $quoteStore->addSecretNote($_POST[lineId], $_POST[addSecretNote]);

            if(isset($_POST[submitSecretNoteEdit]))
                $quoteStore->editSecretNote($_SESSION[quoteId], $_POST[lineId], $_POST[editSecretNote]);

            if(isset($_POST[applyDiscount]))
                $quoteStore->calculateDiscounts($_SESSION[quoteId], $_POST[amount], $_POST[percentage]);

            if(isset($_POST[submitSanction]))
                $quoteStore->updateQuote($_SESSION[quoteId]);
        
        } // end if
    ?>
</body>
</HTML>

<script type="text/javascript">
    function emailSent()
    {
        alert("A confirmation email has been sent to the customer")
    }
</script>