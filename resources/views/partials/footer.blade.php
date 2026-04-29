<footer class="site-footer">

    <!-- Newsletter -->
    <section class="footer-newsletter">
        <div class="container">
            <div class="newsletter-inner">
                <div class="newsletter-text">
                    <h3>Subscribe to Our Newsletter</h3>
                    <p>Receive a regular digest of our latest news and exciting updates.</p>
                </div>

                <form class="newsletter-form" action="#" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email">
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Footer -->
    <section class="footer-main">
        <div class="container">
            <div class="d-none d-md-none d-lg-block">
                <div class="footer-grid">

                    <!-- Logo / Social -->
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="footer-logo">
                            <div class="footer-logo-box"></div>
                        </a>

                        <div class="footer-social">
                            <a href="#" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" aria-label="X">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" aria-label="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div class="footer-col">
                        <h4>Company Info</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Gallery</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-col">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Contato</a></li>
                            <li><a href="#">Track Order</a></li>
                            <li><a href="#">How to Order</a></li>
                            <li><a href="#">How to Design</a></li>
                            <li><a href="#">Payment Guide</a></li>
                            <li><a href="#">Refund Guide</a></li>
                        </ul>
                    </div>

                    <!-- Account -->
                    <div class="footer-col">
                        <h4>Account</h4>
                        <ul>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Create Account</a></li>
                            <li><a href="#">Your Account</a></li>
                        </ul>
                    </div>

                </div>
            </div>
             <div class="d-block d-md-block d-lg-none">
                <div class="footer-grid">

                    <!-- Logo / Social -->
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="footer-logo">
                            <div class="footer-logo-box"></div>
                        </a>

                        <div class="footer-social">
                            <a href="#" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" aria-label="X">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" aria-label="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div class="footer-col">
                        <h4>Company Info</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Gallery</a></li>
                        </ul>
                        <br>
                        <br>
                        <h4>Account</h4>
                        <ul>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Create Account</a></li>
                            <li><a href="#">Your Account</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-col">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Contato</a></li>
                            <li><a href="#">Track Order</a></li>
                            <li><a href="#">How to Order</a></li>
                            <li><a href="#">How to Design</a></li>
                            <li><a href="#">Payment Guide</a></li>
                            <li><a href="#">Refund Guide</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Copyright -->
    <section class="footer-bottom">
        <div class="container">
            <p>Copyright 2026. All rights reserved.</p>
        </div>
    </section>

</footer>
