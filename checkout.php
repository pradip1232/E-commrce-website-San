<?php
include('includes/header.php');
include "config/conn.php";
// session_start();
?>






<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">




<style>
  .selected {
    background-color: #77C712 !important;
    color: white !important;
    border-color: none !important;
    /* Use this class to change background */
  }
</style>







<section class="bg-light py-5 wishlist-container-page">
  <div class="container">
    <div class="row">
      <style>
        .selected {
          /* background-color: lightgreen !important; */
        }
      </style>

      <div class="col-xl-8 col-lg-8 mb-4">
        <form id="checkoutForm" action="pay.php" method="POST">
          <div class="card shadow-0 border">
            <div class="p-4">
              <div class="row">
                <?php
                $e = $_SESSION['user_email'];
                $sql = "SELECT `id`, `name`, `email`, `mobile`, `state`, `country`, `full_add` FROM `user_data` WHERE email = '$e'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $n = htmlspecialchars($row['name']);
                  $m = htmlspecialchars($row['mobile']);
                  $addresses = json_decode($row['full_add'], true);

                  // Check if addresses is an array, otherwise set it to an empty array
                  if (!is_array($addresses)) {
                    $addresses = [];
                  }
                } else {
                  // If no user is found, set addresses to an empty array
                  $addresses = [];
                }
                ?>
                <div class="col-12 mb-3">
                  <p class="mb-0">Full name</p>
                  <div class="form-outline">
                    <input type="text" name="first_name" value="<?php echo $n ?>" class="form-control" required readonly />
                  </div>
                </div>

                <div class="col-6 mb-3">
                  <p class="mb-0">Phone</p>
                  <div class="form-outline">
                    <input type="tel" name="mobile" value="<?php echo $m ?>" class="form-control" required readonly />
                  </div>
                </div>

                <div class="col-6 mb-3">
                  <p class="mb-0">Email</p>
                  <div class="form-outline">
                    <input type="email" name="email" value="<?php echo $e ?>" class="form-control" required readonly />
                  </div>
                </div>
              </div>

              <hr class="my-4" />

              <h5>Your Addresses</h5>
              <div class="row">
                <?php
                foreach ($addresses as $key => $address) {
                  echo "<div class='col-md-4 mb-4'>";
                  echo "<div class='card address-card' data-key='$key' data-address='" . htmlspecialchars(json_encode($address)) . "' style='cursor: pointer;'>";
                  echo "<div class='card-body'>";
                  echo "<h5 class='card-title'>" . htmlspecialchars($key) . "</h5>";
                  echo "<p class='card-text'>";
                  echo "Address Line 1: " . htmlspecialchars($address['line1']) . "<br>";
                  echo "Landmark: " . htmlspecialchars($address['landmark']) . "<br>";
                  echo "City: " . htmlspecialchars($address['city']) . "<br>";
                  echo "State: " . htmlspecialchars($address['state']) . "<br>";
                  echo "Pin Code: " . htmlspecialchars($address['pinCode']) . "<br>";
                  echo "</p></div></div></div>";
                }
                ?>

                <div class="col-sm-3 mb-3">
                  <div class="card border-0 text-center h-100 w-100 p-0" data-bs-toggle="tooltip" title="Add new address">
                    <div class="card-body d-flex align-items-center justify-content-center">
                      <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#addressModal" style="width: 100%; height: 100%;">
                        <i class="bi bi-house-add" style="font-size: 5rem; color: green;"></i>
                      </button>
                    </div>
                  </div>
                </div>

              </div>

              <hr class="my-4" />

              <div class="mb-3">
                <p class="mb-0">Message to seller</p>
                <div class="form-outline">
                  <textarea class="form-control" name="message" rows="2"></textarea>
                </div>
              </div>

              <!-- Hidden fields to store the full address details -->
              <input type="hidden" name="selected_address" id="selectedAddressField" />
              <input type="hidden" name="address_line1" id="addressLine1" />
              <input type="hidden" name="address_landmark" id="addressLandmark" />
              <input type="hidden" name="address_city" id="addressCity" />
              <input type="hidden" name="address_state" id="addressState" />
              <input type="hidden" name="address_pin" id="addressPin" />

              <div class="float-end">
                <button type="button" class="btn btn-light border">Cancel</button>
                <button type="submit" class="btn btn-success shadow-0 border" id="continueBtn" disabled>Continue</button>
              </div>
            </div>
          </div>
        </form>
      </div>


      <script>
        let selectedAddress = null;
        const continueBtn = document.getElementById('continueBtn');
        const selectedAddressField = document.getElementById('selectedAddressField');

        // Hidden fields for address details
        const addressLine1 = document.getElementById('addressLine1');
        const addressLandmark = document.getElementById('addressLandmark');
        const addressCity = document.getElementById('addressCity');
        const addressState = document.getElementById('addressState');
        const addressPin = document.getElementById('addressPin');

        document.querySelectorAll('.address-card').forEach(card => {
          card.addEventListener('click', function() {
            // Remove selected class from all other cards
            document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));

            // Add selected class to the clicked card
            this.classList.add('selected');
            selectedAddress = this.dataset.key;

            // Parse and set the address details in hidden fields
            const address = JSON.parse(this.dataset.address);
            addressLine1.value = address.line1;
            addressLandmark.value = address.landmark;
            addressCity.value = address.city;
            addressState.value = address.state;
            addressPin.value = address.pinCode;

            // Set the hidden field value with the selected address key
            selectedAddressField.value = selectedAddress;

            // Enable the continue button
            continueBtn.disabled = false;
          });
        });
      </script>





      <div class="col-xl-3 col-lg-3 justify-content-center justify-content-lg-end">
        <div class="ms-lg-4 mt-4 mt-lg-0" style="max-width: 320px;">
          <h6 class="mb-3">Summary</h6>
          <?php
          // Get values from URL or set default values
          $price = isset($_GET['price']) ? (float)$_GET['price'] : 0; // Default to 0 if not provided
          $taxType = isset($_GET['tax']) ? $_GET['tax'] : ''; // Tax type, e.g., "included tax"
          $discount = 6.00; // Fixed discount
          $shippingCost = 14.00; // Fixed shipping cost

          // Calculate tax
          if ($taxType === 'included tax') {
            $tax = 0; // No additional tax if included
            $taxMessage = 'Included in the price';
          } else {
            $tax = $price * 0.18; // 18% tax
            $taxMessage = '18% Tax Applied';
          }

          // Calculate total price
          $totalPrice = $price + $tax - $discount + $shippingCost;
          ?>

          <div class="d-flex justify-content-between">
            <p class="mb-2">Total price:</p>
            <p class="mb-2">₹ <?= number_format($price, 2) ?></p>
          </div>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Tax:</p>
            <p class="mb-2 text-success"><?= $taxMessage ?> (₹ <?= number_format($tax, 2) ?>)</p>
          </div>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Discount:</p>
            <p class="mb-2 text-danger">- ₹ <?= number_format($discount, 2) ?></p>
          </div>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Shipping cost:</p>
            <p class="mb-2">+ ₹ <?= number_format($shippingCost, 2) ?></p>
          </div>
          <hr />
          <div class="d-flex justify-content-between">
            <p class="mb-2">Total price:</p>
            <p class="mb-2 fw-bold">₹ <?= number_format($totalPrice, 2) ?></p>
          </div>


          <!-- <div class="input-group mt-3 mb-4">
            <input type="text" class="form-control border" name="" placeholder="Promo code" />
            <button class="btn btn-light text-primary border">Apply</button>
          </div> -->

          <hr />
          <!-- <h6 class="text-dark my-4">Items in cart</h6>

          <div class="d-flex align-items-center mb-4">
            <div class="me-3 position-relative">
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                1
              </span>
              <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/7.webp" style="height: 96px; width: 96x;" class="img-sm rounded border" />
            </div>
            <div class="">
              <a href="#" class="nav-link">
                Gaming Headset with Mic <br />
                Darkblue color
              </a>
              <div class="price text-muted">Total: ₹295.99</div>
            </div>
          </div>

          <div class="d-flex align-items-center mb-4">
            <div class="me-3 position-relative">
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                1
              </span>
              <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/5.webp" style="height: 96px; width: 96x;" class="img-sm rounded border" />
            </div>
            <div class="">
              <a href="#" class="nav-link">
                Apple Watch Series 4 Space <br />
                Large size
              </a>
              <div class="price text-muted">Total: ₹217.99</div>
            </div>
          </div>

          <div class="d-flex align-items-center mb-4">
            <div class="me-3 position-relative">
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                3
              </span>
              <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/1.webp" style="height: 96px; width: 96x;" class="img-sm rounded border" />
            </div>
            <div class="">
              <a href="#" class="nav-link">GoPro HERO6 4K Action Camera - Black</a>
              <div class="price text-muted">Total: ₹910.00</div>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</section>







<!-- Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addressModalLabel">Add New Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addressForm">
          <div class="mb-3">
            <label for="addressLine1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" id="addressLine1" name="addressLine1" required />
          </div>
          <div class="mb-3">
            <label for="addressLine2" class="form-label">Address Line 2</label>
            <input type="text" class="form-control" id="addressLine2" name="addressLine2" />
          </div>
          <div class="mb-3">
            <label for="landmark" class="form-label">Landmark</label>
            <input type="text" class="form-control" id="landmark" name="landmark" />
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control" id="city" name="city" required />
            </div>
            <div class="col">
              <label for="state">State</label>
              <select id="state" name="state" class="form-control" required>
                <option selected disabled>Choose...</option>
                <?php
                $states_and_uts = [
                  'Andhra Pradesh',
                  'Arunachal Pradesh',
                  'Assam',
                  'Bihar',
                  'Chhattisgarh',
                  'Goa',
                  'Gujarat',
                  'Haryana',
                  'Himachal Pradesh',
                  'Jharkhand',
                  'Karnataka',
                  'Kerala',
                  'Madhya Pradesh',
                  'Maharashtra',
                  'Manipur',
                  'Meghalaya',
                  'Mizoram',
                  'Nagaland',
                  'Odisha',
                  'Punjab',
                  'Rajasthan',
                  'Sikkim',
                  'Tamil Nadu',
                  'Telangana',
                  'Tripura',
                  'Uttar Pradesh',
                  'Uttarakhand',
                  'West Bengal',
                  'Andaman and Nicobar Islands',
                  'Chandigarh',
                  'Dadra and Nagar Haveli and Daman and Diu',
                  'Lakshadweep',
                  'Delhi',
                  'Puducherry',
                  'Ladakh',
                  'Lakshadweep',
                  'Jammu and Kashmir'
                ];

                foreach ($states_and_uts as $state_or_ut) {
                  echo "<option value=\"$state_or_ut\">$state_or_ut</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="pinCode" class="form-label">Pin Code</label>
              <input type="text" class="form-control" id="pinCode" name="pinCode" required />
            </div>
            <div class="col">
              <label for="country" class="form-label">Country</label>
              <input type="text" class="form-control" id="country" name="country" required />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="saveAddress()">Save Address</button>
      </div>
    </div>
  </div>
</div>

<script>
  function saveAddress() {
    const formData = new FormData(document.getElementById('addressForm'));

    const addressData = Object.fromEntries(formData.entries());

    fetch('config/save_address.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(addressData),
      })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          $('#addressModal').modal('hide');
          document.getElementById('addressForm').reset();
          alert('Address saved successfully!');
          window.location.reload();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch((error) => {
        console.error('Error:', error);
      });
  }
</script>




<script>
  document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>




















<?php
include('includes/footer.php');
?>



<!-- Bootstrap JS Bundle -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>