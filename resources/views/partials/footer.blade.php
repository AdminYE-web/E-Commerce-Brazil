<footer class="site-footer">

    <!-- Newsletter -->
    <section class="footer-newsletter">
        <div class="container">
            <div class="newsletter-inner">
                <div class="newsletter-text">
                    <h3>{{ __('messages.newsletter.title') }}</h3>
                    <p>{{ __('messages.newsletter.description') }}</p>
                </div>

                <form class="newsletter-form" action="#" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="{{ __('messages.newsletter.email_placeholder') }}">
                    <button type="submit">{{ __('messages.newsletter.subscribe') }}</button>
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
                        <h4>{{ __('messages.footer.company_info') }}</h4>
                        <ul>
                            <li><a href="{{ route('about') }}">{{ __('messages.footer.about_us') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.blog') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.privacy_policy') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.gallery') }}</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-col">
                        <h4>{{ __('messages.footer.support') }}</h4>
                        <ul>
                            <li><a href="#">{{ __('messages.footer.faq') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('messages.footer.contact') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.track_order') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.how_to_order') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.how_to_design') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.payment_guide') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.refund_guide') }}</a></li>
                        </ul>
                    </div>

                    <!-- Account -->
                    <div class="footer-col">
                        <h4>{{ __('messages.footer.account') }}</h4>
                        <ul>
                            <li><a href="{{ route('login') }}">{{ __('messages.footer.login') }}</a></li>
                            <li><a href="{{ route('register') }}">{{ __('messages.footer.create_account') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.your_account') }}</a></li>
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
                        <h4>{{ __('messages.footer.company_info') }}</h4>
                        <ul>
                            <li><a href="{{ route('about') }}">{{ __('messages.footer.about_us') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.blog') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.privacy_policy') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.gallery') }}</a></li>
                        </ul>
                        <br>
                        <br>
                        <h4>{{ __('messages.footer.account') }}</h4>
                        <ul>
                            <li><a href="{{ route('login') }}">{{ __('messages.footer.login') }}</a></li>
                            <li><a href="{{ route('register') }}">{{ __('messages.footer.create_account') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.your_account') }}</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-col">
                        <h4>{{ __('messages.footer.support') }}</h4>
                        <ul>
                            <li><a href="#">{{ __('messages.footer.faq') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('messages.footer.contact') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.track_order') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.how_to_order') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.how_to_design') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.payment_guide') }}</a></li>
                            <li><a href="#">{{ __('messages.footer.refund_guide') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Copyright -->
    <section class="footer-bottom">
        <div class="container">
            <p>{{ __('messages.footer.copyright') }}</p>
        </div>
    </section>

    {{-- WhatsApp Float --}}
    <a href="https://wa.me/819012344567" class="whatsapp-float" target="_blank" rel="noopener">
        <i class="bi bi-whatsapp"></i>
    </a>

</footer>
