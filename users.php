<?php include("header.php"); ?>
<div class="container">
    <div class="span10">
        <div class="user-block">
            <?php
            //Delete User
            if (isset($_GET['delid']) && ctype_digit($_GET['delid'])) {
                Admin_User::deleteUser($_GET['delid']);
            }
            //Display Message
            if (isset($_SESSION[Tools::$USER_MESSAGE])) {
                ?><div class="alert alert-success"><?php echo $_SESSION[Tools::$USER_MESSAGE]; ?></div><?php
                unset($_SESSION[Tools::$USER_MESSAGE]);
            }
            ?>


        </div>
        <table class="table table-hover table-striped">
            <tr class="info">
                <td>ID</td>
                <td>Όνομα χρήστη</td>
                <td>Κατηγορία</td>
                <td>Dealer Code</td>
                <td>Επεξεργασία χρήστη</td>
                <td>Διαγραφή χρήστη</td>
            </tr>
            <?php
            $data = Admin_User::getAllUsers();
            $idCount = 1;
            foreach ($data as $user) {
                ?><tr class="data-<?php echo $user->id  ?>"><?php
                ?><td><?php
                        echo $idCount;
                        $idCount++;
                        ?></td><?php
                        ?><td><?php echo $user->username; ?></td><?php
                        ?><td><?php echo $user->user_type; ?></td><?php
                        ?><td><?php echo $user->dealer_code; ?></td><?php
                        ?><td><a href="#" class="edit-user-data" data-toggle="modal" data-target="#myModal" data-usrid="<?php echo $user->id; ?>"  >Edit</a></td><?php
                        ?><td><a onclick="if (!confirm('Are you sure you want to delete this user'))
                                        return false;" href="users.php?delid=<?php echo $user->id; ?>">Διαγραφή</a></td><?php
                        ?></tr><?php
            }
            ?>
        </table>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Edit user</h3>
    </div>
    <div class="modal-body">
        <!-- Edit User Form -->
        <div class="overlay-layer"></div>
        <div class="user-block">
            <form class="form-horizontal" action="#" method="post" id="add-user-form">
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
                    <label class="control-label" for="inputPassword">Κατηγορία χρήστη</label>
                    <div class="controls">
                        <select name="userType" id="userType" class="input-xlarge">
                            <option value="<?php echo Tools::$CLIENT ?>"><?php echo Tools::$CLIENT ?></option>
                            <option value="<?php echo Tools::$SUPER_CLIENT ?>"><?php echo Tools::$SUPER_CLIENT ?></option>
                            <option value="<?php echo Tools::$SUPER_ADMIN ?>"><?php echo Tools::$SUPER_ADMIN ?></option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputUsername">Dealer Code</label>
                    <div class="controls">
                        <input type="text" name="dealer_code" id="dealerCode" class="input-xlarge">
                    </div>
                </div>
                <input type="hidden" name="update_user" id="update_user" value="" >
            </form>

        </div>
        <!-- end of edit user form -->
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary saveData">Save changes</button>
    </div>
</div>
<script type="text/javascript">

    $('a.edit-user-data').each(function() {
        $(this).click(function(event) {
            var currRow = $(this);
            var userID = $(this).data('usrid');

            if (userID != "" && userID != null && userID != "undefined") {
                $('.overlay-layer').css('display', 'block');
                $.ajax({
                    url: "php-tools/user.php",
                    type: "post",
                    dataType: "text",
                    data: {'edit_user_id': userID},
                    success: function(data) {
                        var usrData = data.split("#|#");
                        $("#update_user").val(usrData[0]);
                        $('#inputUsername').val(usrData[1]);
                        $('#userType').val(usrData[2]);
                        $('#dealerCode').val(usrData[3]);
                        $('.overlay-layer').css('display', 'none');
                    }
                });
            }
        });
    })
    //Save Data
    $(".saveData").click(function(event) {
        $('.overlay-layer').css('display', 'block');
        $.ajax({
            url: "php-tools/user.php",
            type: "post",
            dataType: "text",
            data: {
                  'username':  $('#inputUsername').val(),
                  'password':  $('#inputPassword').val(),
                  'user_type' : $('#userType').val(),
                  'dealer_code' : $('#dealerCode').val(),
                  'update_user' : $('#update_user').val()
            },
            success: function(data) {
               if(data == "1"){
                   var theClassnameToEdit = "data-" + $('#update_user').val();
                   $("."+theClassnameToEdit).find('td:eq(1)').html($('#inputUsername').val());
                   $("."+theClassnameToEdit).find('td:eq(2)').html($('#userType').val());
                   $("."+theClassnameToEdit).find('td:eq(3)').html($('#dealerCode').val());
                   $('#myModal').modal('hide');
                   $('#inputPassword').val("");
               }
            }
        });
    })
</script>
<?php include("footer.php"); ?>