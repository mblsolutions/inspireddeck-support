@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('transaction-content')

    <selected-code v-cloak>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'view_list',
                'title' => 'Transactions',
                'description' => 'View code transactions'
            ])
        </template>
        <template v-slot:transaction>
            <transaction-history></transaction-history>
        </template>
    </selected-code>

@endsection
