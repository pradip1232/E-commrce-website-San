<?php
include "config/db_con.php";


?>


<main>
    <div class="container mt-5">
        <h4>Add Party Details</h4>
        <form id="partyForm">
            <div id="partyRows">
                <div class="row mb-3 party-row">
                    <div class="col-md-5">
                        <input type="text" name="party_name[]" class="form-control" placeholder="Party Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="datetime[]" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success addRow">+</button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Data</button>
        </form>
    </div>
</main>


<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Party Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                
                // Prepare and execute query
                $sql = "SELECT `id`, `party_name`, `created_at` FROM `party_table` WHERE 1";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['party_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No records found</td></tr>";
                }

                // Close connection
                $conn->close();
            } catch (Exception $e) {
                echo "<tr><td colspan='3' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Add new row
        $(document).on('click', '.addRow', function() {
            const dateTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
            $('#partyRows').append(`
        <div class="row mb-3 party-row">
          <div class="col-md-5">
            <input type="text" name="party_name[]" class="form-control" placeholder="Party Name" required>
          </div>
          <div class="col-md-5">
            <input type="text" name="datetime[]" class="form-control" value="${dateTime}" readonly>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-danger removeRow">−</button>
          </div>
        </div>
      `);
        });

        // Remove row
        $(document).on('click', '.removeRow', function() {
            $(this).closest('.party-row').remove();
        });

        // Submit form using AJAX
        $('#partyForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'config/save-party-name.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $('#partyForm')[0].reset();
                    $('#partyRows').html($('.party-row').first()); // Keep one row
                }
            });
        });
    });
</script>