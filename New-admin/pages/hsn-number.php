<?php
include 'config/db_con.php';
?>

<!-- Button to Open Modal -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hsnModal">
    Add New HSN Number
</button>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>HSN Number</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                // Prepare and execute query
                $sql = "SELECT `id`, `hsn_number`, `description`, `status`, `created_at` FROM `hsn_codes` WHERE 1";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['hsn_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . ($row['status'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>') . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-sm btn-primary me-1 edit-btn' data-id='" . htmlspecialchars($row['id']) . "' data-hsn='" . htmlspecialchars($row['hsn_number']) . "' data-desc='" . htmlspecialchars($row['description']) . "' data-bs-toggle='modal' data-bs-target='#editHsnModal'>Edit</button>";
                        echo "<button class='btn btn-sm " . ($row['status'] == 1 ? 'btn-warning' : 'btn-success') . " toggle-status-btn' data-id='" . htmlspecialchars($row['id']) . "' data-status='" . htmlspecialchars($row['status']) . "'>" . ($row['status'] == 1 ? 'Disable' : 'Enable') . "</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                }

                // Close connection
                $conn->close();
            } catch (Exception $e) {
                echo "<tr><td colspan='6' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="hsnModal" tabindex="-1" aria-labelledby="hsnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="hsnForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hsnModalLabel">Add HSN Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="hsnNumber" class="form-label">HSN Number</label>
                    <input type="text" class="form-control" id="hsnNumber" name="hsnNumber" required>
                </div>
                <div class="mb-3">
                    <label for="hsnDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="hsnDescription" name="hsnDescription"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editHsnModal" tabindex="-1" aria-labelledby="editHsnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editHsnForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHsnModalLabel">Edit HSN Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editHsnId">
                <div class="mb-3">
                    <label for="editHsnNumber" class="form-label">HSN Number</label>
                    <input type="text" class="form-control" id="editHsnNumber" name="hsnNumber" required>
                </div>
                <div class="mb-3">
                    <label for="editHsnDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="editHsnDescription" name="hsnDescription"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Add HSN Form Submission
    document.getElementById("hsnForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("config/save-hsn-number.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(response => {
                alert(response);
                this.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('hsnModal'));
                modal.hide();
                window.location.reload();
            })
            .catch(err => {
                console.error(err);
                alert("Error saving HSN Number");
            });
    });

    // Edit HSN Form Submission
    document.getElementById("editHsnForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("config/update-hsn-number.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(response => {
                alert(response);
                const modal = bootstrap.Modal.getInstance(document.getElementById('editHsnModal'));
                modal.hide();
                window.location.reload();
            })
            .catch(err => {
                console.error(err);
                alert("Error updating HSN Number");
            });
    });

    // Populate Edit Modal
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const hsn = this.getAttribute('data-hsn');
            const desc = this.getAttribute('data-desc');

            document.getElementById('editHsnId').value = id;
            document.getElementById('editHsnNumber').value = hsn;
            document.getElementById('editHsnDescription').value = desc;
        });
    });

    // Toggle Status
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            const newStatus = currentStatus == '1' ? '0' : '1';

            fetch("config/toggle-hsn-status.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&status=${newStatus}`
                })
                .then(res => res.text())
                .then(response => {
                    alert(response);
                    window.location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert("Error toggling status");
                });
        });
    });
</script>