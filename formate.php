<?php
session_start(); // Start the session
// include("includes/auth.php");

include("includes/Header.php");
$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* new codwe for csdsdssssssssssssssss */
    .container-fluid1 {
        padding: 0;
        top: 10vh;
        /*padding-top: 56px !important;*/
    }

    .background-image-container {
        /*position: absolute;*/
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .background-image-container img {
        width: 100%;
        height: 86vh;
    }

    .text-container {
        padding: 2px;
    }

    .course-cate-container {
        top: 50px;
        padding-top: 10rem !important;
        /* width: auto; */
        /* height: auto; */
    }

    @media (max-width: 767px) {
        .background-image-container {
            position: relative;
            height: auto;
        }
    }

    .cat-heading33 {
        font-size: 64px;
        color: #5FC3E4;
        ] margin: 0;
        font-weight: 300;
    }

    .course-heading33 {
        font-size: 64px !important;
        margin: 0;
        font-weight: 300;
    }

    .text-container-coursepage {
        margin-top: -483px;
        margin-left: 30px;
        /* width: 65vw; */
    }

    .text-container-coursepage p {
        color: black;
    }
</style>

<div class="container-fluid container-fluid1" style="top:50px;">
    <div class="row">
        <div class="background-image-container">
            <img src="Img/WEBP/course category page slider.webp" alt="">
        </div>
        <div class="container">
            <div class="text-container-coursepage col-6">
                <div class="course-cate" style="color:#E55D87;">
                    <h2 class="course-heading33"> Course </h2>
                    <h2 class="cat-heading33"> Categories</h2>
                </div>
                <p>Explore a wide range of subjects and interests to find the perfect course for you. From
                    academic subjects to skill development programs, language learning to stock trading, we have
                    something for everyone. Start your learning journey today!</p>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="col-lg-12">
        <h2 class="course-bundle" style="color:#E55D87;">Course Bundle</h2>
        <p class="course-bundle-para">Discover our Courses, carefully curated collections of courses designed
            to help you master a specific topic or skill. Whether you're looking to deepen your knowledge in a part
            icular subject area or explore new interests, our bundles offer comprehensive learning experiences at unbe
            atable prices. Dive in and unlock your full potential with our curated course collections.</p>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar">
                <div id="course-categories">
                    <button class="category-btn btn btn-block" data-category="all">All Courses</button>
                    <button class="category-btn btn btn-block" data-category="Stock Trading">Stock Trading</button>
                    <button class="category-btn btn btn-block" data-category="Digital Marketing">Digital Marketing</button>
                    <button class="category-btn btn btn-block" data-category="website building">Website Building</button>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="courses" class="courses-container mt-3">
                <div class="course-card programming stock"
                    onlick="window.location='course-details.php?name=Introduction to Basics&category=Stock Trading&price='">
                    <h4 class="course-haeding1">Introduction to Basics</h4>
                    <p class="color43">
                        <i class="bi bi-backpack3" style="color: black;"></i> 11 lessons
                        <i class="mt-2 bi bi-alarm" style="color: black;"></i> 137Min 19Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i>Certified Instructor
                        </p>
                    </div>
                    <a href="course-details?id=digital4365&name=Introduction to Basics&category=Stock Trading&price="
                        class="category-btn btn btn-info1 no-border border-none" style="border: none;">Explore Further
                        <i class="bi bi-arrow-right" style="color:#E55D87;"></i></a>
                    <!--<a href="course-details.php?id=digital4365&name=Introduction to Basics&category=Stock Trading&price=1999"-->
                    <!--    class="category-btn btn btn-info1 no-border border-none" style="border: none;">Explore Further-->
                    <!--    <i class="bi bi-arrow-right" style="color:#E55D87;"></i></a>-->
                </div>

                <div class="course-card data-science stock">

                    <h4 class="course-haeding1">Advanced Stock Trading</h4>
                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i> 6 lessons
                        <i class="bi bi-alarm" style="color:black;"> </i> 105 Min 19 Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i>Certified Instructor
                        </p>
                    </div>
                    <!--<p><strong>Category:</strong> Stock Trading</p>-->
                    <!--<p><strong>Price:</strong> 2999</p>-->
                    <!--<a href="#" class="category-btn btn btn-info1">Explore Further <i class="bi bi-arrow-right"></i></a>-->
                    <a style="border: none;"
                        href="course-details?id=GYMID8765874&name=Advanced Stock Trading&category=Stock Trading&price="
                        class="category-btn btn btn-info1">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <div class="course-card literature stock">
                    <h4 class="course-haeding1">Stock Trading Combo</h4>

                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i>17 lessons
                        <i class="bi bi-alarm" style="color:black;"></i> 242 Min 38Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i> Certified Instructor
                        </p>
                    </div>
                    <!--<p><strong>Category:</strong> Stock Trading</p>-->
                    <!--<p><strong>Price:</strong> 3999</p>-->
                    <!--<a href="#" class="category-btn btn btn-info1">Explore Further <i class="bi bi-arrow-right"></i></a>-->
                    <a style="border: none;"
                        href="Stock-Trading-Combo.php?name=Stock Trading Combo&category=Stock Trading&price=3999"
                        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <div class="course-card digital">
                    <h4 class="course-haeding1">Content Marketing </h4>

                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i>3 lessons
                        <i class="bi bi-alarm" style="color:black;"></i> 18 Min 54 Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i> Certified Instructor
                        </p>
                    </div>
                    <a style="border: none;" href="content-marketing"
                        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <div class="course-card website">
                    <h4 class="course-haeding1">Website Development (Without Coding)</h4>

                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i>8 lessons
                        <i class="bi bi-alarm" style="color:black;"></i> 59 Min 31 Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i> Certified Instructor
                        </p>
                    </div>
                    <a style="border: none;" href="website-development"
                        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <div class="course-card digital">
                    <h4 class="course-haeding1">Search Engine Optimization (SEO)</h4>

                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i>10 lessons
                        <i class="bi bi-alarm" style="color:black;"></i> 51 Min 19 Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i> Certified Instructor
                        </p>
                    </div>
                    <a style="border: none;" href="search-engine-optimization"
                        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <div class="course-card digital">
                    <h4 class="course-haeding1">Facebook & Instagram Ads Course </h4>

                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i>12 lessons
                        <i class="bi bi-alarm" style="color:black;"></i> 1hr 23 min 48 sec

                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i> Certified Instructor
                        </p>
                    </div>
                    <a style="border: none;" href="facebook-and-instagram-ads-course"
                        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <div class="course-card digital">
                    <h4 class="course-haeding1">Blogging</h4>

                    <p class="color43">
                        <i class="bi bi-backpack3" style="color:black;"></i>4 lessons
                        <i class="bi bi-alarm" style="color:black;"></i> 12 Min 52 Sec
                    </p>
                    <div class="small-content">
                        <p>
                            <i class="bi bi-check"></i> Full lifetime access
                            <i class="bi bi-check"></i> Learn at your own pace
                            <i class="bi bi-check"></i> Certified Instructor
                        </p>
                    </div>
                    <a style="border: none;" href="blogging"
                        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"
                            style="color:#E55D87;"></i></a>

                </div>
                <!--<div class="course-card digital">-->
                <!--    <h4 class="course-haeding1">Email Marketing</h4>-->

                <!--    <p class="color43">-->
                <!--        <i class="bi bi-backpack3" style="color:black;"></i>7 lessons-->
                <!--        <i class="bi bi-alarm" style="color:black;"></i> 18 Min 54 Sec-->
                <!--    </p>-->
                <!--    <div class="small-content">-->
                <!--        <p>-->
                <!--            <i class="bi bi-check"></i> Full lifetime access-->
                <!--            <i class="bi bi-check"></i> Learn at your own pace-->
                <!--            <i class="bi bi-check"></i> Certified Instructor-->
                <!--        </p>-->
                <!--    </div>-->
                <!--    <a style="border: none;" href="email-marketing"-->
                <!--        class="category-btn btn btn-info1 border-none">Explore Further <i class="bi bi-arrow-right"-->
                <!--            style="color:#E55D87;"></i></a>-->

                <!--</div>-->
            </div>
        </div>
    </div>
</div>









<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Your custom script -->
<script>
    $(document).ready(function() {
        // Load all courses initially
        showCourses('all');

        // Function to show courses based on category
        function showCourses(category) {
            $('.course-card').hide(); // Hide all course cards
            if (category === 'all') {
                $('.course-card').fadeIn(); // Show all course cards
            } else {
                $('.course-card').each(function() {
                    if ($(this).hasClass(category)) {
                        $(this).fadeIn(); // Show course cards of selected category
                    }
                });
            }
            if (category === 'Digital Marketing') {
                $('.digital').fadeIn(); // Show all course cards
            } else {
                $('.course-card').each(function() {
                    if ($(this).hasClass(category)) {
                        $(this).fadeIn(); // Show course cards of selected category
                    }
                });
            }
            if (category === 'Stock Trading') {
                $('.stock').fadeIn(); // Show all course cards
            } else {
                $('.digital').each(function() {
                    if ($(this).hasClass(category)) {
                        $(this).fadeIn(); // Show course cards of selected category
                    }
                });
            }
            if (category === 'website building') {
                $('.website').fadeIn(); // Show all course cards
            } else {
                $('.digital').each(function() {
                    if ($(this).hasClass(category)) {
                        $(this).fadeIn(); // Show course cards of selected category
                    }
                });
            }
        }

        // Click event handler for category buttons
        $('.category-btn').click(function() {
            var category = $(this).data('category');
            showCourses(category);
        });
    });
</script>
















<div class="container custom-container mt-4">
    <div class="row ">
        <div class="col-md-5">

            <img src="Img/WEBP/What Others Have To Say About Us.webp" alt="Image" class="custom-image">
        </div>
        <div class="col-md-6">

            <h2 class="p-3 sayabout">What Others Have To Say About Us</h2>
            <p class="p-4">Ready to embark on your learning journey? Explore our diverse range of courses and start
                learning today! With expertly crafted content, interactive lessons, and flexible learning options, Gyani
                Mind provides the perfect environment for you to expand your knowledge and skills. Whether you're a
                student, professional, or lifelong learner, there's something for everyone on our platform. Join our
                community of learners and discover the joy of lifelong learning with us.
            </p>
            <button type="button" class="btn browser-btn float-center">Browse Reviews</button>
        </div>
    </div>
</div>

<style>
    .content {
        background-color: #E55D87;
        border: 2px solid #E55D87;
        padding: 20px;
        height: 250px;
        width: 90%;
        z-index: -1;
        margin-top: 20px;
        margin-left: 500px;
    }

    .content-text {
        text-align: left;
        color: white;
        margin-left: 120px;
        font-size: x-large;
    }

    .content-text1 {
        text-align: left;
        color: white;
        margin-left: 130px;
        font-size: 40px;
    }

    .content-text2 {
        text-align: left;
        color: white;
        margin-left: 220px;
        font-size: x-large;
    }

    .bi-image {
        width: 100px;
        height: 100px;
        margin-top: 100px;

    }

    .btn-check {

        margin-left: 220px;
        border: 1px;
        border-radius: 8px;
        width: 120px;
        color: black;
    }

    @media screen and (max-width: 786px) {
        .content {
            margin-top: 20px;
            width: 40%;
        }

        .bi-image {
            margin-top: 750px;
        }

        .education-img {
            height: 24vh;
            width: 24vw;
        }

        .eeducation-study {
            display: flex;
        }
    }
</style>

<!--<div class="container-fluid">-->
<!--    <div class="row">-->
<!--      <div class="col-md-12 eeducation-study">-->
<!--        <div class="bi-image" style="padding:20px;">-->
<!--            <img src="Img/13 2.png" alt="Image" class="education-img">-->
<!--          </div>-->
<!--          <div class="content">-->
<!--            <p class="content-text">The Future of-->
<!--                <p class="content-text1">Education is Here</p></p>-->
<!--                <p class="content-text2">Join our E-Learning Community Today!</p>-->
<!--                <button class="btn-check" type="button" >AI Courses</button>-->
<!--          </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->





<?php


include("includes/footer.php");
?>




<!-- Bootstrap JS via CDN (optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // document.addEventListener("DOMContentLoaded", function() {
    // const coursesContainer = document.getElementById("courses");
    // const coursesData = [{
    // name: "Introduction to Basics",
    // category: "Stock Trading"
    // },
    // {
    //     name: "Advanced Stock Trading",
    //     category: "Stock Trading"
    // },
    // {
    //     name: "Stock Trading Combo",
    //     category: "Stock Trading"
    // }
    // ,
    // {
    //     name: "Introduction to JavaScript",
    //     category: "programming"
    // },
    // {
    //     name: "Python for Data Science",
    //     category: "data-science"
    // },
    // {
    //     name: "Machine Learning Basics",
    //     category: "data-science"
    // },
    // {
    //     name: "Data Visualization with Python",
    //     category: "data-science"
    // },
    // {
    //     name: "Introduction to Statistics",
    //     category: "data-science"
    // },
    // {
    //     name: "English Literature Classics",
    //     category: "literature"
    // },
    // {
    //     name: "World History: Ancient Civilizations",
    //     category: "history"
    // },
    // {
    //     name: "Introduction to Psychology",
    //     category: "psychology"
    // },
    // ];

    // function displayCourses(category) {
    //     coursesContainer.innerHTML = "";

    //     coursesData.forEach(course => {
    //         if (category === "all" || course.category === category) {
    //             const courseCard = document.createElement("div");
    //             courseCard.classList.add("course-card");
    //             courseCard.innerHTML = `
    //                   <h4>${course.name}</h4>
    //                   <p><strong>Category:</strong> ${course.category}</p>
    //             <a href="course-details.php?name=${encodeURIComponent(course.name)}&category=${encodeURIComponent(course.category)}" class="category-btn btn btn-info1">Explore Further <i class="bi bi-arrow-right"></i></a>

    //               `;
    //             coursesContainer.appendChild(courseCard);
    //         }
    //     });
    // }

    //     const categoryButtons = document.querySelectorAll(".category-btn");
    //     categoryButtons.forEach(button => {
    //         button.addEventListener("click", function() {
    //             const category = this.getAttribute("data-category");
    //             displayCourses(category);
    //         });
    //     });

    //     displayCourses("all"); // Display all courses by default
    // });
</script>