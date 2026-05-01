<footer class="site-footer-shell">
    <div class="page-container">
        <div class="site-footer-grid">
            <div class="site-footer-brand">
                <div class="brand-lockup brand-lockup-footer">
                    <img src="{{ asset('images/Logo.png') }}" alt="XyberaBoost logo" class="brand-mark">
                    <div>
                        <p class="brand-name">XyberaBoost</p>
                        <p class="brand-tagline">{{ __('common.trusted_by_gamers') }}</p>
                    </div>
                </div>
                <p class="site-footer-copy">{{ __('common.footer_about_text') }}</p>
                <div class="site-footer-contact">
                    <p>{{ __('common.company_address') }}</p>
                    <a href="mailto:{{ __('common.company_email') }}">{{ __('common.company_email') }}</a>
                </div>
            </div>

            <div class="site-footer-links">
                <p class="section-kicker">{{ __('common.quick_links') }}</p>
                <div class="site-footer-link-grid">
                    <a href="{{ route('home') }}">{{ __('common.home') }}</a>
                    <a href="{{ route('pages', 'about-us') }}">{{ __('common.about') }}</a>
                    <a href="{{ route('contact') }}">{{ __('common.contact') }}</a>
                    <a href="{{ route('pages', 'terms-conditions') }}">{{ __('common.terms_policy') }}</a>
                    <a href="{{ route('pages', 'privacy-policy') }}">{{ __('common.privacy_policy') }}</a>
                    <a href="{{ route('pages', 'delivery-policy') }}">{{ __('common.delivery_policy') }}</a>
                    <a href="{{ route('pages', 'refund-policy') }}">{{ __('common.refund_policy') }}</a>
                </div>
            </div>

            <div class="site-footer-newsletter">
                <p class="section-kicker">Subscribe to our newsletter</p>
                <h3>{{ __('common.stitch_newsletter_title') }}</h3>
                <p>{{ __('common.newsletter_text') }}</p>
                <form action="{{ route('subscribe') }}" method="POST" class="site-footer-newsletter-form">
                    @csrf
                    <input type="email" class="hud-input footer-newsletter-input" name="email" placeholder="{{ __('common.enter_email') }}" required>
                    <button type="submit" class="hud-btn hud-btn-primary w-full">{{ __('common.subscribe') }}</button>
                </form>
            </div>
        </div>

        <div class="site-footer-bottom">
            <p>&copy; 2026 XyberaBoost. All Rights Reserved.</p>
            <div class="site-footer-bottom-links">
                <a href="{{ route('pages', 'privacy-policy') }}">{{ __('common.privacy_policy') }}</a>
                <a href="{{ route('pages', 'terms-conditions') }}">{{ __('common.terms_policy') }}</a>
                <a href="{{ route('pages', 'refund-policy') }}">{{ __('common.refund_policy') }}</a>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>
<script src="{{ asset('assets/js/circularProgressBar.min.js') }}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/swiper.min.js') }}"></script>
<script src="{{ asset('assets/js/lightcase.js') }}"></script>
<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
