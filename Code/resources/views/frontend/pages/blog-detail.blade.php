@extends('frontend.layouts.master')

@section('title', 'EliteLift Gaming || Blog Detail Page')

@section('main-content')
    @php
        $tags = array_filter(array_map('trim', explode(',', $post->tags ?? '')));
    @endphp

    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 grid gap-10 lg:grid-cols-[1fr_0.92fr] lg:items-center">
                    <div>
                        <span class="section-label">Article</span>
                        <h1 class="section-title max-w-4xl">{{ $post->title }}</h1>
                        <div class="mt-6 flex flex-wrap items-center gap-4 text-xs uppercase tracking-[0.16em] text-on-surface-variant">
                            <span class="inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-primary">person</span>
                                {{ $post->author_info['name'] ?? 'Anonymous' }}
                            </span>
                            <span class="inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-primary">calendar_month</span>
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                            <span class="inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-primary">chat</span>
                                {{ $post->allComments->count() }} Comments
                            </span>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <a href="{{ route('blog') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                Blog
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                Article
                            </span>
                        </div>
                    </div>

                    <div class="glass-panel border-white/10 bg-black/20 p-6 sm:p-8">
                        <p class="font-headline text-xs uppercase tracking-[0.2em] text-primary">Reading Summary</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-on-surface">Discussion, tips, and updates</h2>
                        <p class="mt-4 text-sm leading-7 text-on-surface-variant sm:text-base">
                            This article page keeps the existing post, comment, and sidebar route behavior while presenting the content in the same visual language as the redesigned storefront.
                        </p>
                        <div class="mt-6 space-y-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Comment route preserved: <span class="font-semibold text-on-surface">`/post/{{ $post->slug }}/comment`</span>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-on-surface-variant">
                                Newsletter route preserved: <span class="font-semibold text-on-surface">`/subscribe`</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8 grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-8">
                <article class="glass-panel overflow-hidden">
                    <img src="{{ $post->photo }}" alt="{{ $post->title }}" class="h-[320px] w-full object-cover sm:h-[420px]">

                    <div class="p-6 sm:p-8">
                        <div class="sharethis-inline-reaction-buttons"></div>

                        @if($post->quote)
                            <blockquote class="mt-8 rounded-[1.75rem] border border-primary/15 bg-primary/10 px-6 py-6 text-lg leading-8 text-on-surface">
                                {!! $post->quote !!}
                            </blockquote>
                        @endif

                        <div class="prose prose-invert mt-8 max-w-none text-on-surface-variant">
                            {!! $post->description !!}
                        </div>

                        @if(count($tags))
                            <div class="mt-8 border-t border-white/10 pt-6">
                                <p class="font-headline text-xs uppercase tracking-[0.18em] text-primary">Tags</p>
                                <div class="mt-4 flex flex-wrap gap-3">
                                    @foreach($tags as $tag)
                                        <a href="{{ route('blog.tag', $tag) }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-on-surface-variant transition hover:border-primary/30 hover:text-primary">
                                            {{ $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                <div class="glass-panel p-6 sm:p-8">
                    @auth
                        <div class="reply-head comment-form" id="commentFormContainer">
                            <div class="border-b border-white/10 pb-6">
                                <span class="section-label">Join The Discussion</span>
                                <h2 class="text-3xl font-black tracking-tight text-on-surface">Leave a comment</h2>
                            </div>

                            <form class="form comment_form mt-8 space-y-5" id="commentForm" action="{{ route('post-comment.store', $post->slug) }}" method="POST">
                                @csrf
                                <div class="comment_form_body">
                                    <label class="mb-3 block text-xs uppercase tracking-[0.18em] text-on-surface-variant">Your Message</label>
                                    <textarea name="comment" id="comment" rows="8" class="topup-input min-h-[180px]" placeholder="Share your thoughts"></textarea>
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="parent_id" id="parent_id" value="">
                                </div>

                                <div class="form-group button">
                                    <button type="submit" class="btn-primary">
                                        <span class="comment_btn comment">Post Comment</span>
                                        <span class="comment_btn reply" style="display: none;">Reply Comment</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="rounded-[1.75rem] border border-dashed border-white/15 bg-white/5 px-6 py-10 text-center">
                            <p class="text-sm leading-7 text-on-surface-variant sm:text-base">
                                You need to
                                <a href="{{ route('login.form') }}" class="font-semibold text-primary transition hover:text-white">Login</a>
                                or
                                <a href="{{ route('register.form') }}" class="font-semibold text-primary transition hover:text-white">Register</a>
                                to comment.
                            </p>
                        </div>
                    @endauth
                </div>

                <div class="glass-panel p-6 sm:p-8">
                    <div class="border-b border-white/10 pb-6">
                        <span class="section-label">Comments</span>
                        <h2 class="text-3xl font-black tracking-tight text-on-surface">Comments ({{ $post->allComments->count() }})</h2>
                    </div>

                    <div class="mt-8">
                        @include('frontend.pages.comment', ['comments' => $post->comments, 'post_id' => $post->id, 'depth' => 3])
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Search</h2>
                    <form class="mt-5 space-y-4" method="GET" action="{{ route('blog.search') }}">
                        <input type="text" placeholder="Search Here..." name="search" class="topup-input">
                        <button class="btn-primary w-full justify-center" type="submit">Search</button>
                    </form>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Blog Categories</h2>
                    <div class="mt-5 space-y-3">
                        @foreach(Helper::postCategoryList('posts') as $cat)
                            <a href="{{ route('blog.category', $cat->slug) }}" class="block rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-3 text-sm text-on-surface-variant transition hover:border-primary/30 hover:text-primary">
                                {{ $cat->title }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Recent Posts</h2>
                    <div class="mt-5 space-y-4">
                        @foreach($recent_posts as $recent_post)
                            <a href="{{ route('blog.detail', $recent_post->slug) }}" class="flex items-center gap-4 rounded-[1.5rem] border border-white/10 bg-white/5 p-3 transition hover:border-primary/30 hover:bg-primary/5">
                                <img src="{{ $recent_post->photo }}" alt="{{ $recent_post->title }}" class="h-16 w-16 rounded-2xl object-cover">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-on-surface">{{ $recent_post->title }}</p>
                                    <p class="mt-1 text-sm text-on-surface-variant">{{ $recent_post->created_at->format('d M, y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Tags</h2>
                    <div class="mt-5 flex flex-wrap gap-3">
                        @foreach(Helper::postTagList('posts') as $tag)
                            <a href="{{ route('blog.tag', $tag->title) }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-on-surface-variant transition hover:border-primary/30 hover:text-primary">
                                {{ $tag->title }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="glass-panel p-6">
                    <h2 class="font-headline text-lg font-bold uppercase tracking-[0.16em] text-on-surface">Subscribe to our newsletter</h2>
                    <p class="mt-4 text-sm leading-7 text-on-surface-variant">
                        Get updates when new articles, news, and storefront guidance are published.
                    </p>
                    <form action="{{ route('subscribe') }}" method="POST" class="mt-5 space-y-4">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email" class="topup-input">
                        <button type="submit" class="btn-primary w-full justify-center">Submit</button>
                    </form>
                </div>
            </aside>
        </section>
    </main>
@endsection

@push('styles')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            (function ($) {
                "use strict";

                $('.btn-reply.reply').click(function (e) {
                    e.preventDefault();
                    $('.btn-reply.reply').show();

                    $('.comment_btn.comment').hide();
                    $('.comment_btn.reply').show();

                    $(this).hide();
                    $('.btn-reply.cancel').hide();
                    $(this).siblings('.btn-reply.cancel').show();

                    var parent_id = $(this).data('id');
                    var html = $('#commentForm');
                    $(html).find('#parent_id').val(parent_id);
                    $('#commentFormContainer').hide();
                    $(this).parents('.comment-list').append(html).fadeIn('slow').addClass('appended');
                });

                $('.comment-list').on('click', '.btn-reply.cancel', function (e) {
                    e.preventDefault();
                    $(this).hide();
                    $('.btn-reply.reply').show();

                    $('.comment_btn.reply').hide();
                    $('.comment_btn.comment').show();

                    $('#commentFormContainer').show();
                    var html = $('#commentForm');
                    $(html).find('#parent_id').val('');

                    $('#commentFormContainer').append(html);
                });
            })(jQuery)
        })
    </script>
@endpush
