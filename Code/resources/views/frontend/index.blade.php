@extends('frontend.layouts.master')

@section('title', 'EliteLift Gaming | Home')
@section('meta_description', 'Explore premium boosting categories, purchase points, and move faster through a secure EliteLift Gaming storefront.')

@section('main-content')
@php
    $heroCategory = $category_lists->first();
    $featuredCategories = collect($category_lists)->take(6);
    $spotlightCategories = collect($category_lists)->take(3);
@endphp

<main class="pb-24">
    <section class="home-hero section-shell">
        <div class="page-container">
            <div class="hud-shell">
                <div class="hud-grid-lines"></div>

                <div class="hero-command-strip">
                    <div class="eyebrow-chip">{{ __('common.stitch_hero_chip') }}</div>
                    <div class="hero-status-line">
                        <span>{{ __('common.stitch_status_categories') }} {{ collect($category_lists)->count() }}</span>
                        <span>{{ __('common.stitch_status_currency') }} {{ session('currency', 'USD') }}</span>
                        <span>{{ __('common.stitch_status_locale') }} {{ app()->getLocale() === 'ja' ? __('common.japanese') : __('common.english') }}</span>
                    </div>
                </div>

                <div class="hero-layout">
                    <div class="hero-copy-panel">
                        <p class="section-kicker">{{ __('common.stitch_hero_kicker') }}</p>
                        <h1 class="display-title">{{ __('common.stitch_hero_title') }}</h1>
                        <p class="lead-copy">{{ __('common.stitch_hero_text') }}</p>

                        <div class="hero-cta-row">
                            <a href="{{ route('product-lists') }}" class="hud-btn hud-btn-primary">{{ __('common.purchase_services') }}</a>
                            <a href="{{ route('register.form') }}" class="hud-btn hud-btn-secondary">{{ __('common.join_us_today') }}</a>
                        </div>

                        <p class="system-note">Purchased points can only be used on this website.</p>

                        <div class="hero-metric-grid">
                            <div class="hud-stat">
                                <span class="hud-stat-value">{{ collect($category_lists)->count() }}+</span>
                                <span class="hud-stat-label">{{ __('common.metric_categories') }}</span>
                            </div>
                            <div class="hud-stat">
                                <span class="hud-stat-value">200+</span>
                                <span class="hud-stat-label">{{ __('common.metric_services') }}</span>
                            </div>
                            <div class="hud-stat">
                                <span class="hud-stat-value">24/7</span>
                                <span class="hud-stat-label">{{ __('common.metric_support') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-visual-stack">
                        <div class="hero-media-frame">
                            @if($heroCategory && !empty($heroCategory->photo))
                                <img src="{{ url($heroCategory->photo) }}" alt="{{ $heroCategory->title }}" class="hero-media-image">
                            @else
                                <div class="hero-media-fallback">
                                    <span>ELG</span>
                                </div>
                            @endif
                            <div class="hero-media-glow"></div>
                        </div>

                        @if($heroCategory)
                            <article class="hero-spotlight-card">
                                <div class="hero-spotlight-head">
                                    <p class="section-kicker">{{ __('common.collection_title') }}</p>
                                    <span class="hero-spotlight-tag">{{ __('common.spotlight_label') }}</span>
                                </div>
                                <h2>{{ $heroCategory->title }}</h2>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($heroCategory->summary), 170) }}</p>
                                <div class="hero-spotlight-meta">
                                    <span>{{ __('common.stitch_spotlight_meta') }}</span>
                                    <a href="{{ route('product-cat', $heroCategory->slug) }}" class="hud-inline-link">{{ __('common.explore_game') }}</a>
                                </div>
                            </article>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="page-container">
            <div class="section-header-row">
                <div>
                    <p class="section-kicker">{{ __('common.collection_title') }}</p>
                    <h2 class="section-heading">{{ __('common.stitch_categories_title') }}</h2>
                </div>
                <p class="section-header-copy">{{ __('common.stitch_categories_text') }}</p>
            </div>

            <div class="category-command-grid">
                @foreach($featuredCategories as $category)
                    <article class="category-command-card">
                        <div class="category-command-top">
                            <p class="category-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                            <span class="category-chip">{{ __('common.game_label') }}</span>
                        </div>
                        <div class="category-command-media">
                            @if(!empty($category->photo))
                                <img src="{{ url($category->photo) }}" alt="{{ $category->title }}" class="category-command-image">
                            @else
                                <div class="category-command-fallback">{{ $category->title }}</div>
                            @endif
                        </div>
                        <h3>{{ $category->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($category->summary), 130) }}</p>
                        <div class="category-command-actions">
                            <span>{{ __('common.stitch_category_signal') }}</span>
                            <a href="{{ route('product-cat', $category->slug) }}" class="hud-inline-link">{{ __('common.view_services') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="page-container">
            <div class="section-header-row">
                <div>
                    <p class="section-kicker">{{ __('common.spotlight_label') }}</p>
                    <h2 class="section-heading">{{ __('common.stitch_showcase_title') }}</h2>
                </div>
                <p class="section-header-copy">{{ __('common.stitch_showcase_text') }}</p>
            </div>

            <div class="showcase-stack">
                @foreach($spotlightCategories as $spotlightCategory)
                    <article class="showcase-row-card">
                        <div class="showcase-row-copy">
                            <p class="section-kicker">{{ __('common.stitch_showcase_label') }}</p>
                            <h3>{{ $spotlightCategory->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($spotlightCategory->summary), 180) }}</p>
                        </div>
                        <div class="showcase-row-actions">
                            <span>{{ __('common.stitch_showcase_route') }}</span>
                            <a href="{{ route('product-cat', $spotlightCategory->slug) }}" class="hud-btn hud-btn-secondary">{{ __('common.explore_game') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="page-container">
            <div class="points-layout">
                <div class="points-control-panel">
                    <div class="section-header-row section-header-row-tight">
                        <div>
                            <p class="section-kicker">{{ __('common.points_topup_title') }}</p>
                            <h2 class="section-heading">{{ __('common.stitch_points_title') }}</h2>
                        </div>
                    </div>
                    <p class="lead-copy">{{ __('common.stitch_points_text') }}</p>

                    <form action="{{ route('points-add-to-cart') }}" method="POST" class="points-form-shell">
                        @csrf
                        <input type="hidden" name="quant[1]" value="1" id="quantity">
                        <input type="hidden" name="slug" value="points">
                        <input type="hidden" name="points" id="total_points" required readonly>

                        <div>
                            <label for="price" class="input-shell-label">{{ __('common.label_amount') }}</label>
                            <div class="hud-input-shell">
                                <span class="hud-input-prefix">{{ Helper::getCurrencySymbol(session('currency')) }}</span>
                                <input
                                    type="number"
                                    class="hud-input"
                                    placeholder="{{ __('common.placeholder_amount', ['currency' => Helper::getCurrencySymbol(session('currency'))]) }}"
                                    min="1"
                                    max="9999999"
                                    name="price"
                                    id="price"
                                    required
                                    oninput="if(this.value > 9999999) this.value = 9999999;"
                                >
                            </div>
                        </div>

                        <div class="points-stat-grid">
                            <div class="points-stat-card">
                                <p id="pointst">0</p>
                                <span>{{ __('common.label_points') }}</span>
                            </div>
                            <div class="points-stat-card">
                                <p id="bonus_pointst">0</p>
                                <span>{{ __('common.bonus_points') }}</span>
                            </div>
                            <div class="points-stat-card">
                                <p id="total_pointst">0</p>
                                <span>{{ __('common.total_points') }}</span>
                            </div>
                        </div>

                        <div class="system-note">{{ __('common.stitch_points_note') }}</div>
                        <p class="system-note">Base service pricing generally starts at 30–40 points, with add-ons available at 20 points per hour.</p>
                        <button class="hud-btn hud-btn-primary w-full" type="submit">{{ __('common.add_cart') }}</button>
                    </form>
                </div>

                <div class="points-info-panel">
                    <div class="bonus-panel">
                        <div class="bonus-panel-header">
                            <p class="section-kicker">{{ __('common.bonus_tier_title') }}</p>
                            <h3>{{ __('common.stitch_bonus_title') }}</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="bonus-hud-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.bonus_table_range') }} ({{ Helper::getCurrencySymbol(session('currency')) }})</th>
                                        <th>{{ __('common.bonus_table_multiplier') }}</th>
                                        <th>{{ __('common.bonus_table_benefit') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ session('currency') == 'JPY' ? 'JPY 1 - JPY 100,000' : (session('currency') == 'HKD' ? 'HK$ 1 - HK$ 5,000' : '$1 - $600') }}</td>
                                        <td>1x {{ __('common.label_points') }}</td>
                                        <td>{{ __('common.bonus_standard') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ session('currency') == 'JPY' ? 'JPY 100,001 - JPY 300,000' : (session('currency') == 'HKD' ? 'HK$ 5,001 - HK$ 15,000' : '$601 - $2,000') }}</td>
                                        <td>1.5x {{ __('common.label_points') }}</td>
                                        <td>{{ __('common.bonus_50_extra') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ session('currency') == 'JPY' ? 'JPY 300,001 - JPY 500,000' : (session('currency') == 'HKD' ? 'HK$ 15,001 - HK$ 25,000' : '$2,001 - $3,200') }}</td>
                                        <td>2x {{ __('common.label_points') }}</td>
                                        <td>{{ __('common.bonus_100_extra') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ session('currency') == 'JPY' ? 'JPY 500,001 and above' : (session('currency') == 'HKD' ? 'HK$ 25,001 and above' : '$3,201 and above') }}</td>
                                        <td>5x {{ __('common.label_points') }}</td>
                                        <td>{{ __('common.bonus_400_extra') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p class="bonus-panel-note">{{ __('common.bonus_note') }}</p>
                    </div>

                    <div class="flow-panel">
                        <p class="section-kicker">{{ __('common.how_it_works_title') }}</p>
                        <h3>{{ __('common.stitch_flow_title') }}</h3>
                        <div class="flow-grid">
                            <div class="flow-step-card">
                                <span>01</span>
                                <p>{{ __('common.how_step_1') }}</p>
                            </div>
                            <div class="flow-step-card">
                                <span>02</span>
                                <p>{{ __('common.how_step_2') }}</p>
                            </div>
                            <div class="flow-step-card">
                                <span>03</span>
                                <p>{{ __('common.how_step_3') }}</p>
                            </div>
                            <div class="flow-step-card">
                                <span>04</span>
                                <p>{{ __('common.how_step_4') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell section-shell-last">
        <div class="page-container">
            <div class="section-heading-center">
                <p class="section-kicker">{{ __('common.features_title') }}</p>
                <h2 class="section-heading">{{ __('common.stitch_trust_title') }}</h2>
            </div>

            <div class="trust-grid">
                <article class="trust-card">
                    <span class="material-symbols-outlined">shield</span>
                    <h3>{{ __('common.feature_transparent_title') }}</h3>
                    <p>{{ __('common.feature_transparent_text') }}</p>
                </article>
                <article class="trust-card">
                    <span class="material-symbols-outlined">rocket_launch</span>
                    <h3>{{ __('common.feature_higher_topup_title') }}</h3>
                    <p>{{ __('common.feature_higher_topup_text') }}</p>
                </article>
                <article class="trust-card">
                    <span class="material-symbols-outlined">bolt</span>
                    <h3>{{ __('common.feature_instant_bonus_title') }}</h3>
                    <p>{{ __('common.feature_instant_bonus_text') }}</p>
                </article>
                <article class="trust-card">
                    <span class="material-symbols-outlined">military_tech</span>
                    <h3>{{ __('common.feature_better_value_title') }}</h3>
                    <p>{{ __('common.feature_better_value_text') }}</p>
                </article>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var currency = "{{ session('currency') }}";

        function basicpoints(truepoints) {
            truepoints = parseFloat(truepoints);
            if (currency === "HKD") {
                truepoints = truepoints / 8;
            } else if (currency === "JPY") {
                truepoints = truepoints / 160;
            } else if (currency === "USD") {
                truepoints = truepoints;
            }

            return Math.floor(truepoints);
        }

        function calpoints(truepoints) {
            truepoints = parseFloat(truepoints);
            if (currency === "HKD") {
                switch (true) {
                    case (truepoints > 1 && truepoints < 5000):
                        truepoints = truepoints;
                        break;
                    case (truepoints > 5000 && truepoints < 15001):
                        truepoints = Math.floor(truepoints * 1.5);
                        break;
                    case (truepoints > 15000 && truepoints < 25001):
                        truepoints = Math.floor(truepoints * 2);
                        break;
                    case (truepoints > 25000):
                        truepoints = Math.floor(truepoints * 5);
                        break;
                    default:
                        truepoints = truepoints;
                        break;
                }
                truepoints = truepoints / 8;
            } else if (currency === "JPY") {
                switch (true) {
                    case (truepoints > 1 && truepoints < 100001):
                        truepoints = truepoints;
                        break;
                    case (truepoints > 100000 && truepoints < 300001):
                        truepoints = Math.floor(truepoints * 1.5);
                        break;
                    case (truepoints > 300000 && truepoints < 500001):
                        truepoints = Math.floor(truepoints * 2);
                        break;
                    case (truepoints > 500000):
                        truepoints = Math.floor(truepoints * 5);
                        break;
                    default:
                        truepoints = truepoints;
                        break;
                }
                truepoints = truepoints / 160;
            } else if (currency === "USD") {
                switch (true) {
                    case (truepoints > 1 && truepoints < 601):
                        truepoints = truepoints;
                        break;
                    case (truepoints > 600 && truepoints < 2001):
                        truepoints = Math.floor(truepoints * 1.5);
                        break;
                    case (truepoints > 2000 && truepoints < 3201):
                        truepoints = Math.floor(truepoints * 2);
                        break;
                    case (truepoints > 3200):
                        truepoints = Math.floor(truepoints * 5);
                        break;
                    default:
                        truepoints = truepoints;
                        break;
                }
            }

            return Math.floor(truepoints);
        }

        function updatePoints() {
            let value = $("#price").val();
            if (!value || isNaN(value)) {
                value = 0;
            }

            $("#total_points").val(calpoints(value));
            $("#pointst").text(basicpoints(value));
            $("#bonus_pointst").text(calpoints(value) - basicpoints(value));
            $("#total_pointst").text(calpoints(value));
        }

        $("#price").on("keyup change input", updatePoints);
        updatePoints();
    });
</script>
@endpush('scripts')
