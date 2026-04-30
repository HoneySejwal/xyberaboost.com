@if(session('success'))
    <div class="alert alert-success alert-dismissable fade show rounded-[1.25rem] border border-success/30 bg-success/10 px-5 py-4 text-sm text-on-surface">
        <button class="close text-on-surface-variant" data-dismiss="alert" aria-label="Close">&times;</button>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissable fade show rounded-[1.25rem] border border-error/30 bg-error/10 px-5 py-4 text-sm text-on-surface">
        <button class="close text-on-surface-variant" data-dismiss="alert" aria-label="Close">&times;</button>
        {{ session('error') }}
    </div>
@endif
