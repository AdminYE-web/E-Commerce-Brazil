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
                            <li><a href="{{ route('blog.index') }}">{{ __('messages.footer.blog') }}</a></li>
                            <li><a href="{{ route('privacy.policy') }}">{{ __('messages.footer.privacy_policy') }}</a></li>
                            <li><a href="{{ route('gallery.index') }}">{{ __('messages.footer.gallery') }}</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-col">
                        <h4>{{ __('messages.footer.support') }}</h4>
                        <ul>
                            <li><a href="#">{{ __('messages.footer.faq') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('messages.footer.contact') }}</a></li>
                            <li><a href="{{ route('track-order.index') }}">{{ __('messages.footer.track_order') }}</a></li>
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
                            <li><a href="{{ route('blog.index') }}">{{ __('messages.footer.blog') }}</a></li>
                            <li><a href="{{ route('privacy.policy') }}">{{ __('messages.footer.privacy_policy') }}</a></li>
                            <li><a href="{{ route('gallery.index') }}">{{ __('messages.footer.gallery') }}</a></li>
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
                            <li><a href="{{ route('track-order.index') }}">{{ __('messages.footer.track_order') }}</a></li>
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

    <div class="cookie-policy-popup" id="cookiePolicyPopup">
    <div class="cookie-policy-inner">
        <div class="cookie-policy-icon">
                      <img src="{{ asset('assets/images/icon/image-Photoroom (73) 1.png') }}" alt="" class="img-fluid">

            <span class="cookie-check">✓</span>
        </div>

        <div class="cookie-policy-content">
            <h3>Nós valorizamos sua privacidade.</h3>
            <p>
                Utilizamos cookies para garantir a melhor experiência em nosso site,
                <a href="{{ route('privacy.policy') }}" target="_blank">
                    de acordo com nossa Política de Privacidade.
                </a>
            </p>
        </div>

        <div class="cookie-policy-actions">
            <button type="button" class="cookie-accept-btn" id="acceptCookiesBtn">
                Aceitar Todos
            </button>

            <button type="button" class="cookie-reject-btn" id="rejectCookiesBtn">
                Recusar não essenciais
            </button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('cookiePolicyPopup');
    const acceptBtn = document.getElementById('acceptCookiesBtn');
    const rejectBtn = document.getElementById('rejectCookiesBtn');

    const storageKey = 'cookie_policy_consent';
    const sevenDays = 7 * 24 * 60 * 60 * 1000;

    function getCookieConsent() {
        const saved = localStorage.getItem(storageKey);

        if (!saved) {
            return null;
        }

        try {
            const data = JSON.parse(saved);
            const now = new Date().getTime();

            if (!data.expires_at || now > data.expires_at) {
                localStorage.removeItem(storageKey);
                return null;
            }

            return data;
        } catch (error) {
            localStorage.removeItem(storageKey);
            return null;
        }
    }

    function saveCookieConsent(status) {
        const now = new Date().getTime();

        const data = {
            status: status,
            accepted_at: now,
            expires_at: now + sevenDays
        };

        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    function showPopup() {
        if (popup) {
            popup.classList.add('is-show');
        }
    }

    function hidePopup() {
        if (popup) {
            popup.classList.remove('is-show');
        }
    }

    const consent = getCookieConsent();

    if (!consent) {
        showPopup();
    }

    if (acceptBtn) {
        acceptBtn.addEventListener('click', function () {
            saveCookieConsent('accepted');
            hidePopup();
        });
    }

    if (rejectBtn) {
        rejectBtn.addEventListener('click', function () {
            saveCookieConsent('rejected_non_essential');
            hidePopup();
        });
    }
});
</script>

</footer>
