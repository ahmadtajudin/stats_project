<?php include("header.php"); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="span2">
                <!-- Link or button to toggle dropdown -->
                <div class="toggle-state"><a href="#"><b>Choose Chart</b></a></div>
                <ul class="nav nav-list bs-docs-sidenav show-hide-el">
                    <li <?php if(!isset($_GET["chart"]) || $_GET["chart"]=='le')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=le">Λόγοι Επίσκεψης</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='ee')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=ee">Συνολικές επισκέψεις</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='1')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=1">Γενικές Εντυπώσεις</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='2')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=2">Εγκαταστάσεις</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='3')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=3">Προσωπικό</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='4')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=4">Θέματα Χρόνου</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='5')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=5">Ποιότητα</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='6')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=6">Ποιότητα – Δεύτερη επίσκεψη</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='7')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=7">Κόστη</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='8')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=8">Follow Up</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='9')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=9">Στο μέλλον</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='epma')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=epma">Επικοινωνία πελάτη με αντιπροσωπεία</a>
                    </li>
                    <li <?php if(isset($_GET["chart"]) && $_GET["chart"]=='kk')print 'class="active"'; ?>>
                        <i class="icon-chevron-right"></i><a href="graphs.php?chart=kk">Κλείσιμο Κλήσης</a>
                    </li>
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
<?php include("footer.php"); ?>