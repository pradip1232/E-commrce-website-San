<div class="container-fluid custom-footer-bg pt-5 mt-5  pb-5">
	<footer class="text-dark">
		<div class="container-fluid px-5">
			<div class="row">

				<!-- First Column: Logo and Paragraph -->
				<div class="col-md-4">
					<a class="navbar-brand pt-0 mt-0" href="#">
						<img src="assets/images/12 1.png" alt="Logo" class="logo pt-0" style="max-width: 100%; margin-top: -3rem;">
					</a>
					<p class="log-text  text-center-mobile" style="margin-top: -2rem;">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laborum suscipit vero reprehenderit asperiores magnam, doloribus minus fugiat. Neque consequatur saepe aperiam laboriosam? Odio, consequuntur mollitia eos veritatis amet ipsa rem?
					</p>
				</div>

				<!-- Second Column: About and Social Media Icons -->
				<div class="col-md-3">
					<h5 class="text-left text-center-mobile">About</h5>
					<ul class="list-unstyled text-left text-center-mobile">
						<li><a href="#" class="text-dark text-decoration-none">C-74/1, ph-2, Vijay Vihar</a></li>
						<li><a href="#" class="text-dark text-decoration-none">Near Rohini Sector-4</a></li>
						<li><a href="#" class="text-dark text-decoration-none">New Delhi, Delhi India 110085</a>
						</li>
					</ul>

					<div class="mt-2 text-left text-center-mobile mobile-images">
						<a href="#" class="text-dark"><img src="assets/images/Group.png" alt="" class="image-mobile"></a>
						<a href="#" class="text-dark"><img src="assets/images/Group 265.png" alt="" class="image-mobile"></a>
						<a href="#" class="text-dark"><img src="assets/images/Group (2).png" alt="" class="image-mobile"></a>
						<a href="#" class="text-dark"><img src="assets/images/Group (2).png" alt="" class="image-mobile"></a>
						<a href="#" class="text-dark"><img src="assets/images/Group (4).png" alt="" class="image-mobile"></a>
					</div>

				</div>
				<!-- Third Column: Useful Links -->
				<div class="col-md-2">
					<h5 class="text-left text-center-mobile">Useful Links</h5>
					<ul class="list-unstyled text-left text-center-mobile">
						<li><a href="#" class="text-dark text-decoration-none">Privacy Policy</a></li>
						<li><a href="#" class="text-dark text-decoration-none">Return & Refunds</a></li>
						<li><a href="#" class="text-dark text-decoration-none">Terms & Condition</a></li>
						<li><a href="#" class="text-dark text-decoration-none">Shipping Policy</a></li>
					</ul>
				</div>
				<!-- Fourth Column: My Account -->
				<div class="col-md-2">
					<h5 class="text-left text-center-mobile">My Account</h5>
					<ul class="list-unstyled text-left text-center-mobile">
						<li><a href="#" class="text-dark text-decoration-none">Sign In</a></li>
						<li><a href="#" class="text-dark text-decoration-none">Order History</a></li>
						<li><a href="#" class="text-dark text-decoration-none">View Cart</a></li>
						<li><a href="#" class="text-dark text-decoration-none">My Wishlist</a></li>
						<li><a href="#" class="text-dark text-decoration-none">Track My Order</a></li>
					</ul>
				</div>
			</div>
			<hr>
			<!-- Payment Icons -->
			<div class="row justify-content-center">
				<div class="col-md-6 text-center">
					<img src="assets/images/13 14.png" class="" style="max-width: 136px;">
					<img src="assets/images/13 13.png" alt="UPI" class="img-fluid mb-3" style="max-width: 136px;">
					<img src="assets/images/13 12.png" alt="PhonePe" class="img-fluid" style="max-width: 136px;">
				</div>
			</div>

			<div class="text-center mt-3">
				<p>Divya Jyoti Foundation &copy; 2024. All rights reserved.</p>
			</div>
		</div>
	</footer>

</div>



<!-- toggle behaviour -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelector('.navbar-toggler').addEventListener('click', function() {
			var icon = this.querySelector('.navbar-toggler-icon');
			if (icon.classList.contains('cross-icon')) {
				icon.classList.remove('cross-icon');
				this.setAttribute('aria-expanded', 'false');
			} else {
				icon.classList.add('cross-icon');
				this.setAttribute('aria-expanded', 'true');
			}
		});
	});
</script>
<!--  -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- seasonal slider script  -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
	$(document).ready(function() {
		$('#productCarousel').carousel({
			interval: 2000 // Adjust the speed of auto sliding (in milliseconds)
		});
	});
</script>
<script>
	$('.carousel .carousel-item').each(function() {
		var minPerSlide = 4;
		var next = $(this).next();
		if (!next.length) {
			next = $(this).siblings(':first');
		}
		next.children(':first-child').clone().appendTo($(this));

		for (var i = 0; i < minPerSlide; i++) {
			next = next.next();
			if (!next.length) {
				next = $(this).siblings(':first');
			}

			next.children(':first-child').clone().appendTo($(this));
		}
	});
	
	// Wait for the DOM content to load
	document.addEventListener("DOMContentLoaded", function() {
		// Hide the horizontal scrollbar
		document.body.style.overflowX = "hidden";
	});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="/assets/js/products.js"></script>

</body>

</html>