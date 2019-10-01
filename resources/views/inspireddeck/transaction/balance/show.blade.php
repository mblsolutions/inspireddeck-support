@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'account_balance_wallet',
                'title' => 'Balance Check',
                'description' => 'Perform a balance check against code',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <balance-check></balance-check>
        </template>
    </selected-code>

@endsection
