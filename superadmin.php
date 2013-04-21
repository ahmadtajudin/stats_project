<?php include("header.php"); ?>
<div class="container">
    <div class="span9">
        <div class="user-block">
            <h4>Δημιουργία νέου χρήστη</h4>
            <?php
            if (isset($_SESSION[Tools::$USER_MESSAGE])) {
                ?><div class="alert alert-success"><?php echo $_SESSION[Tools::$USER_MESSAGE]; ?></div><?php
                unset($_SESSION[Tools::$USER_MESSAGE]);
            }
            ?>
            <form class="form-horizontal" action="php-tools/user.php" method="post" id="add-user-form">
                <div class="control-group">
                    <label class="control-label" for="inputUsername">Όνομα χρήστη</label>
                    <div class="controls">
                        <input type="text" name="username" id="inputUsername" class="input-xlarge">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Κωδικός</label>
                    <div class="controls">
                        <input type="password" name="password" id="inputPassword" class="input-xlarge">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Επιβεβαίωση Κωδικού</label>
                    <div class="controls">
                        <input type="password" name="confirm_password" id="inputPassword2" class="input-xlarge">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Κατηγορία χρήστη</label>
                    <div class="controls">
                        <select name="userType" class="input-xlarge">
                            <option value="<?php echo Tools::$CLIENT ?>"><?php echo Tools::$CLIENT ?></option>
                            <option value="<?php echo Tools::$SUPER_CLIENT ?>"><?php echo Tools::$SUPER_CLIENT ?></option>
                            <option value="<?php echo Tools::$SUPER_ADMIN ?>"><?php echo Tools::$SUPER_ADMIN ?></option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn" value="Καταχώρηση" />
                        <input type="hidden" name="add_user" value="1" />
                    </div>
                </div>
            </form>

        </div>
        <div class="user-block">
            <h4>Εισαγωγή αρχείου</h4>
            <?php
            if (isset($_SESSION[Tools::$USER_MESSAGE])) {
                ?><div class="alert alert-success"><?php echo $_SESSION[Tools::$USER_MESSAGE]; ?></div><?php
                unset($_SESSION[Tools::$USER_MESSAGE]);
            }
            ?>
            <form class="form-horizontal" action="php-tools/tools.php" method="post" id="add-excel-data-form" enctype="multipart/form-data">
                <div class="control-group">
                    <label class="control-label" for="inputUsername">Επιλέξτε πίνακα</label>
                    <div class="controls">
                        <select id="table_name" name="table_name" class="input-xlarge">
                            <option value="">Επιλέξτε πίνακα</option>
                            <option value="data">Data</option>
                            <option value="dealers">Dealers</option>
                            <option value="passby">Passby</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputUsername">Choose File</label>
                    <div class="controls">
                        <input type="file" name="excel_file_data" id="excel_file_data" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn" value="Ανεβάστε αρχείο" />
                        <input type="hidden" name="add_excel_data" value="1" />
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="span3">
        <div class="toggle-state right-box"><a href="#">Διαχείριση χρηστών</a></div>
        <ul class="nav nav-list bs-docs-sidenav show-hide-el">
            <li><i class="icon-chevron-right"></i><a href="users.php">Διαχείριση χρηστών</a></li>
        </ul>
    </div>

</div>
<script type="text/javascript">
    $(function() {
        // validate add user form
        $("#add-user-form").validate({
            rules: {
                username: "required",
                password: "required",
                confirm_password: {
                    required: true,
                    equalTo: "#inputPassword"
                },
                userType: "required"
            },
            messages: {
                username: "Enter your username",
                password: "Provide your password",
                confirm_password: "Please enter same password"
            },
            success: function(label) {
                label.remove();
            }
        });

        // validate import data form
        $("#add-excel-data-form").validate({
            rules: {
                table_name: "required"
            },
            messages: {
                table_name: "Please select database table for import"
            },
            success: function(label) {
                label.remove();
            }
        });
    })
</script>
<?php include("footer.php"); ?>