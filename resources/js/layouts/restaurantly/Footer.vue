<script setup lang="ts">

</script>

<template>
    <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">MeatHouse Grill</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Shop 13, Kingfisher Square</p>
                        <p>69 Kingfisher Ave</p>
                        <p>Elspark, Germiston, 1418</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+27 10 011 3806</span></p>
                        <p><strong>Email:</strong> <span>info@meathousegrill.co.za</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#menu">Our Menu</a></li>
                        <li><a href="#specials">Specials</a></li>
                        <li><a href="#contact">Find Us</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-3 footer-links">
                    <h4>Why Meathousegrill Grill</h4>
                    <ul>
                        <li>Flame-grilled for that real smoky flavour</li>
                        <li>Generous portions at the best value</li>
                        <li>Bold, locally inspired recipes</li>
                        <li>Freshly made, fast & friendly service</li>
                        <li>Made with passion. Served with pride.</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                        <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>

            </div>
        </div>

        <div class="container copyright text-left mt-4">
            <p>© <span>Copyright</span> <strong>Meathouse Grill</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Theme originally designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Website developed by <a href="https://www.rikscss.co.za" target="_blank">RiksCSS</a>
            </div>
        </div>

    </footer>
</template>
