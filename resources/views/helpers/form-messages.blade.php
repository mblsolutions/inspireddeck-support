@if ($errors->any())
    <div class="error-alert">
        <p class="align-middle font-bold text-base">
            <i class="material-icons text-sm">error</i> An error occurred.
        </p>
        <ul class="text-sm mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('success'))
    <div class="success-alert">
        <p class="align-middle font-bold text-base">
            <i class="material-icons text-sm">check_circle</i> {{ session()->get('success') }}
        </p>
    </div>
@endif

@if (session()->has('deleted'))
    <div class="error-alert">
        <p class="align-middle font-bold text-base">
            <i class="material-icons text-sm">error</i> {{ session()->get('deleted') }}
        </p>
    </div>
@endif

@if (session()->has('transaction_response'))
    <div class="success-alert">
        <p class="align-middle font-bold text-base">
            <i class="material-icons text-sm">done</i> {{ session()->get('transaction_response') }}
        </p>
    </div>
@endif
