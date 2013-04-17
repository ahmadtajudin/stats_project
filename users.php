<?php include("header.php"); ?>
<div class="container">
    <div class="span10">
        <div class="user-block">
            <?php
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
                <td>Επεξεργασία χρήστη</td>
                <td>Διαγραφή χρήστη</td>
            </tr>
            <?php
              $data =  Admin_User::getAllUsers();
              $idCount = 1;
              foreach($data as $user){
                  ?><tr><?php
                  ?><td><?php echo $idCount; $idCount++;  ?></td><?php
                  ?><td><?php echo $user->username;  ?></td><?php 
                  ?><td><?php echo $user->user_type;  ?></td><?php 
                  ?><td><a href="edit-user.php?id=<?php echo $user->id; ?>">Edit</a></td><?php 
                  ?><td><a onclick="if(!confirm('Are you sure you want to delete this user')) return false;" href="users.php?delid=<?php echo $user->id; ?>">Διαγραφή</a></td><?php 
                   ?></tr><?php
              }
            ?>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        // validate signup form on keyup and submit
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
    })
</script>
<?php include("footer.php"); ?>