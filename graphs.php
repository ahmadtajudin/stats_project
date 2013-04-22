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
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=3">Chart 3</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=4">Chart 4</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=1">Chart 5</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=2">Chart 6</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=3">Chart 7</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=4">Chart 8</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=1">Chart 9</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=2">Chart 10</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=3">Chart 11</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=4">Chart 12</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=1">Chart 13</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=2">Chart 14</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=3">Chart 15</a></li>
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