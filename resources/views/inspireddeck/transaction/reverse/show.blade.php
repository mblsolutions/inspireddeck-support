@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code v-cloak>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'history',
                'title' => 'Reverse Transaction',
                'description' => 'Reverse a previous transaction on code',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <reverse-transaction></reverse-transaction>
        </template>
    </selected-code>

@endsection
