@extends('user.layouts.master')

@section('title', 'EliteLift Gaming || Comment Page')

@section('main-content')
    <main class="pb-20 pt-6 sm:pt-10">
        <section class="page-container">
            <div class="glass-panel relative overflow-hidden px-6 py-10 sm:px-10 lg:px-12 lg:py-14">
                <div class="hero-orb left-[-4rem] top-[-3rem] h-44 w-44 bg-primary/20"></div>
                <div class="hero-orb bottom-[-4rem] right-[-2rem] h-52 w-52 bg-secondary/20"></div>

                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="section-label">User Comments</span>
                        <h1 class="section-title">Comment Lists</h1>
                        <p class="section-copy mt-6">
                            Manage your submitted blog comments through the existing user comment routes, including edit and delete actions.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-on-surface-variant">
                            <a href="{{ route('home') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 transition hover:border-primary/40 hover:text-primary">
                                {{ __('common.home') }}
                            </a>
                            <span>/</span>
                            <span class="rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-primary">
                                Comment Lists
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Comments</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">{{ count($comments) }}</p>
                        </div>
                        <div class="metric-card">
                            <p class="font-headline text-xs uppercase tracking-[0.22em] text-primary">Actions</p>
                            <p class="mt-3 text-2xl font-black text-on-surface">Edit and delete</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-container mt-8">
            <div class="glass-panel p-6 sm:p-8">
                <div class="row">
                    <div class="col-md-12">
                        @include('backend.layouts.notification')
                    </div>
                </div>

                <div class="mt-4 border-b border-white/10 pb-6">
                    <span class="section-label">Comment Lists</span>
                    <h2 class="text-3xl font-black tracking-tight text-on-surface sm:text-4xl">Your submitted comments</h2>
                </div>

                <div class="mt-8 overflow-x-auto">
                    @if(count($comments) > 0)
                        <table class="w-full min-w-[980px] overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/5 text-left" id="order-dataTable">
                            <thead>
                                <tr class="bg-white/5">
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">S.N.</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Author</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Post Title</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Message</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Date</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Status</th>
                                    <th class="px-4 py-4 text-xs uppercase tracking-[0.18em] text-primary">Action</th>
                                </tr>
                            </thead>
                            <tfoot class="hidden">
                                <tr>
                                    <th>S.N.</th>
                                    <th>Author</th>
                                    <th>Post Title</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($comments as $comment)
                                    <tr class="border-t border-white/10">
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $comment->id }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface">{{ $comment->user_info['name'] }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $comment->post->title }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $comment->comment }}</td>
                                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $comment->created_at->format('M d D, Y g: i a') }}</td>
                                        <td class="px-4 py-4">
                                            @if($comment->status == 'active')
                                                <span class="rounded-full border border-success/30 bg-success/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-success">{{ $comment->status }}</span>
                                            @else
                                                <span class="rounded-full border border-warning/30 bg-warning/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-warning">{{ $comment->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('user.post-comment.edit', $comment->id) }}" class="btn-ghost">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('user.post-comment.delete', [$comment->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn-ghost border-error/30 text-error hover:bg-error/10 dltBtn" data-id="{{ $comment->id }}">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-end">
                            {{ $comments->links() }}
                        </div>
                    @else
                        <div class="rounded-[1.75rem] border border-dashed border-white/15 bg-white/5 px-6 py-12 text-center">
                            <h6 class="text-center text-on-surface-variant">No post comments found!!!</h6>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

    <script>
        $('#order-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [5, 6]
                }
            ]
        });

        function deleteData(id) {
        }
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function (e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })
        })
    </script>
@endpush
