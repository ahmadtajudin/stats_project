<?php include("header.php"); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="span2">
                <!-- Link or button to toggle dropdown -->
                <div class="toggle-state"><a href="#">Choose Chart</a></div>
                <ul class="nav nav-list bs-docs-sidenav show-hide-el">
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=1">ΛΟΓΟΙ ΕΠΙΣΚΕΨΗΣ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=2">ΕΠΑΝΑΛΗΨΗ ΕΠΙΣΚΕΨΗΣ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=3">ΓΕΝΙΚΈΣ ΕΝΤΥΠΏΣΕΙΣ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=4">ΕΓΚΑΤΑΣΤΆΣΕΙΣ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=5">ΠΡΟΣΩΠΙΚΌ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=6">ΘΈΜΑΤΑ ΧΡΌΝΟΥ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=7">ΠΟΙΌΤΗΤΑ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=8">ΣΕ ΠΕΡΊΠΤΩΣΗ ΠΟΥ ΧΡΕΙΆΣΤΗΚΕ ΝΑ ΕΠΙΣΤΡΈΨΕΤΕ ΣΤΗΝ ΑΝΤΙΠΡΟΣΩΠΕΊΑ ΓΙΑ ΕΠΙΠΛΈΟΝ ΕΡΓΑΣΊΑΣ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=9">ΚΌΣΤΗ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=10">FOLLOW UP</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=11">ΣΤΟ ΜΈΛΛΟΝ</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=12">ΚΛΕΊΣΙΜΟ ΚΛΉΣΗΣ</a></li>
                </ul>
            </div>
            <div class="span10">
                <div class="chart-container">
                    <!-- chart content goes here -->
                    <?php require_once './graphs/graphs_holder.php'; ?>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $('.toggle-state').click(function(event) {
        $('ul.show-hide-el').slideToggle(300, function() {
            if ($('ul.show-hide-el').css('display') == 'block') {
                $('.toggle-state  a ').css('background', '#0088cc url(images/minus-icon.png) 97% center no-repeat');
            }
            else if ($('ul.show-hide-el').css('display') == 'none') {
                $('.toggle-state  a ').css('background', '#0088cc url(images/plus-icon.png) 97% center no-repeat');
            }
        })
    });
</script>
<?php include("footer.php"); ?>