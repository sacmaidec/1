<?php

include "../../includes/config.php";

$sql = "SELECT * FROM users ";
$result = $mysqli->query($sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    
    ?>  
    <div class="table-responsive">     
        <table  id="table" class="table table-striped table-hover table-light text-center" style="width: 100%" border="1" class="table" align="center"; width="50%" cellspacing="0px">
            <thead class="table-light">
                <tr>
                    
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Applied Jobs</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        $id = $row["uid"];
                        ?>            
                            <tr>
                                
                                <td><?php echo $row['firstname']?></td>
                                <td><?php echo $row['lastname']?></td>
                                <td><?php echo $row['email']?></td>
                                <td><?php echo $row['applied_jobs']?></td>
                                <td>  
                                    <a class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#edit_modal<?php echo $row['uid']; ?>"><i class="fas fa-edit"></i></a> 
                                    <button type="submit" class="userDel btn btn-sm btn-outline-danger" id="<?= $id ?>"><i class="fas fa-trash"></i></button>
                                </td>
                                <?php include "userUpdateModal.php"; ?>
                            </tr>
                        <?php
                    }
                ?>
            </tbody>
            
        </table>
        </div>
    <?php
} else {
    echo "There are no records found";
}

?>
<script>
    $(document).ready(function() {
        $("#table").DataTable({
            dom:  "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>"+ 
                  "<'row'<'col-sm-12'tr>>"+ 
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "order": [[ 0, "desc" ]],
            "pageLength": 10,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'CCSTQS Accounts',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'CCSTQS Accounts',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    title: 'CCSTQS Accounts',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );                    
                    }                     
                }                
            ]
        });  

        $(".userUpdate").click(function(){

        $id=$(this).val();
               
        var fname = $('#firstname' + $id).val();
        var fname = $('#firstname' + $id).val();
        var lname = $('#lastname' + $id).val();
        var uname = $('#email' + $id).val();
        var role = $('#applied_jobs' + $id).val();

        $.ajax({
            url: "userMgmt/userUpdate.php",
            type: "POST",
            dataType: "json",
            data: {
                id: $id,
                firstname: firstname,
                lastname: lastname,
                email: email,
                applied_jobs: applied_jobs
            },
            success: function(data, status, xhr){

                $('#edit_modal' + $id).modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                
            
                $.get("userMgmt/userFetch.php", function(data, status, xhr){
                    $("#user_data").html(data);
                });
  
                // Show success message without "OK" button
                Swal.fire({
                    title: 'Updated!',
                    text: 'User has been successfully updated.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000 // Auto close after 1.5 seconds
                });
            }
        });


    });

    $('.userDel').click(function(e) {
    e.preventDefault();

    var id = $(this).attr('id');

    // Display confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, proceed with deletion
            $.ajax({
                url: "userMgmt/userDel.php",
                type: "POST",
                data: { id: id },
                success: function(data, status, xhr) {
                    // Update UI after successful deletion
                    $.get("userMgmt/userFetch.php", function(data, status, xhr) {
                        $("#user_data").html(data);
                    });
                    // Show success message without "OK" button
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User has been successfully deleted.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000 // Auto close after 1.5 seconds
                    });
                },
                error: function(xhr, status, error) {
                    // Show error message if deletion fails
                    Swal.fire(
                        'Error!',
                        'Failed to delete user. Please try again later.',
                        'error'
                    );
                }
            });
        }
    });
});

    });             

</script>
