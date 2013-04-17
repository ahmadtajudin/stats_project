<?php include("header.php"); ?>
<div class="container">
    <div class="span12">
        <h4 class="span10 user-title">Καλώς ήλθατε, <span><?php echo $userData->username; ?></span></h4>
        <h4 class="span10 user-title">Σύνολο εγγραφών: <span><?php echo Tools::getDataCount(); ?></span></h4>
        <table class="table">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td><a href="#">ID</a></td>
                    <td><a href="#">Serial</a></td>
                    <td><a href="#">Dealer Code</a></td>
                    <td><a href="#">Area</a></td>
                    <td><a href="#">Chain</a></td>
                    <td><a href="#">Months</a></td>
                    <td><a href="#">Year</a></td>
                </tr>
                <tr  class="tick-border"><?php Tools::getDataTableLastRow(); ?></tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><a href="#">ID</a></td>
                    <td><a href="#">Months</a></td>
                    <td><a href="#">Year</a></td>
                    <td><a href="#">Passby</a></td>
                    <td><a href="#">Dealer Code</a></td>
                    <td><a href="#">Area</a></td>
                    <td><a href="#">Chains</a></td>
                </tr>
                <tr class="tick-border">
                    <?php echo Tools::getPassbyTableLastRow(); ?>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><a href="#">ID</a></td>
                    <td><a href="#">Dealer Code</a></td>
                    <td><a href="#">Dealer Name</a></td>
                    <td><a href="#">Dealer Area</a></td>
                    <td><a href="#">Chain</a></td>
                    <td><a href="#">&nbsp;</a></td>
                    <td><a href="#">&nbsp;</a></td>
                </tr>
                <tr class="tick-border">
                    <?php echo Tools::getDealersTableLastRow(); ?>
                </tr>
            </tbody>
        </table>
        <?php //print_r($userData); ?>
    </div>

</div>

<?php include("footer.php"); ?>