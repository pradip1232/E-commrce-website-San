<?php
include ('includes/header.php')
    ?>









<div>

    <section>
        <div class="container-fluid p-0 position-relative">
            <img src="./assets/images/pharmacy.png" alt="" class="img-fluid w-100" />
            <div class="blurred-background">
                <div class="blurred-background">
                    <h2 class="text-black lets-talk-blur mb-0">Let's Talk</h2>
                    <h2 class="text-black mb-0 keep-connected">Keep Connected With us</h2>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid mt-5 pt-5 text-center" style="background-color: #F4F4F4;">
            <div class="row justify-content-center mt-5">
                <div class="col-md-12">
                    <form id="contactForm" action="#" method="post">
                        <div class="row mb-1">
                            <label for="name" class="col-sm-2 col-form-label mb-0">Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control border-none mb-1" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="email" class="col-sm-2 col-form-label mb-0">Email:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control mb-1 border-none" id="email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="phone" class="col-sm-2 col-form-label mb-0">Phone:</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control mb-1 border-none" id="phone" name="phone"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="message" class="col-sm-2 col-form-label mb-0">Message:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control mb-1 border-none" id="message" name="message" rows="4"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="row mb-2 justify-content-center">
                            <div class="col-sm-22">
                                <button type="submit" class="btn-contact-form d-block mx-auto">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container-fluid pt-5 mt-5">
            <div class="row justify-content-center g-0">
                <div class="col-auto store-first-container">
                    <div class="contact-item text-center mt-3">
                        <img src="/assets/images/Group 257 (1).png" class="img-fluid mx-auto d-block"
                            alt="Contact Image">
                        <p class="mt-3 store-bottom-heading">store@djfoundation.co</p>
                    </div>
                </div>
                <div class="col-auto store-first-container-2">
                    <div class="contact-item text-center mt-3">
                        <img src="/assets/images/Group 260.png" class="img-fluid mx-auto d-block" alt="Contact Image">
                        <p class="mt-3 store-bottom-heading-2">sanjeevika@gmail.com</p>
                        <p>sanjeevika@gmail.com</p>
                    </div>
                </div>
                <div class="col-auto store-first-container-3">
                    <div class="contact-item text-center mt-3">
                        <img src="/assets/images/Group 244 (2).png" class="img-fluid mx-auto d-block"
                            alt="Contact Image">
                        <p class="mt-3 store-bottom-heading-3">C-74/1, Ph-2, Vijay Vihar</p>
                        <p class="store-bottom-heading-4">Near Rohini Sector-4</p>
                        <p class="store-bottom-heading-5">New Delhi, Delhi India 110085</p>
                    </div>
                </div>
                <div class="col-auto store-first-container-4">
                    <div class="contact-item text-center mt-3">
                        <img src="/assets/images/Group 244 (2).png" class="img-fluid mx-auto d-block"
                            alt="Contact Image">
                        <p class="mt-3 store-bottom-heading-6">+91 00000 00000</p>
                        <p class="store-bottom-heading-7">+91 00000 00000</p>
                        <p class="store-bottom-heading-8">+91 00000 00000</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>









<?php
include ('includes/footer.php')
    ?>