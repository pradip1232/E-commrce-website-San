  <!-- Sidebar Start -->
  <?php
    $current_page = basename($_SERVER['PHP_SELF'], ".php"); // Get the current page name
    ?>

  <div class="sidebar">
      <div class="scrollbar-inner sidebar-wrapper">
          <ul class="nav">
              <li class="nav-item <?php echo ($current_page == 'my-profile') ? 'active' : ''; ?>">
                  <a href="my-profile">
                      <i class="bi bi-people"></i>
                      <p>My Profile</p>
                  </a>
              </li>
              <li class="nav-item <?php echo ($current_page == 'my-products') ? 'active' : ''; ?>">
                  <a href="my-products">
                      <i class="la la-table"></i>
                      <p>My Products</p>
                  </a>
              </li>
              <!-- <li class="nav-item <?php echo ($current_page == 'my-wishlist') ? 'active' : ''; ?>">
                  <a href="my-wishlist">
                      <i class="la la-heart"></i>
                      <p>My Wishlist</p>
                  </a>
              </li> -->
          </ul>
      </div>
  </div>


  <!-- Sidebar End -->