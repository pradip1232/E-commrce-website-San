<!-- Button to Open Modal -->
<button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#taxRateModal">
    Add New Tax Rate
</button>

<!-- Modal -->
<div class="modal fade" id="taxRateModal" tabindex="-1" aria-labelledby="taxRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="taxRateForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taxRateModalLabel">Add Tax Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="taxRate" class="form-label">Tax Rate (%)</label>
                    <input type="number" step="0.01" class="form-control" id="taxRate" name="taxRate" required>
                </div>
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                </div>
                <div class="mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("taxRateForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const taxRate = document.getElementById("taxRate").value;
        const startDate = new Date(document.getElementById("startDate").value);
        const endDate = new Date(document.getElementById("endDate").value);

        // Validation: End date must be greater than start date
        if (endDate <= startDate) {
            alert("End Date must be greater than Start Date.");
            return;
        }

        const formData = new FormData(this);

        fetch("config/save-tax-rate.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(response => {
                alert(response);
                this.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('taxRateModal'));
                modal.hide();
            })
            .catch(err => {
                console.error(err);
                alert("Error saving Tax Rate");
            });
    });
</script>