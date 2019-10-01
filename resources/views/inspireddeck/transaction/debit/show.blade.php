@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'remove',
                'title' => 'Debit Code',
                'description' => 'Remove funds from code',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <debit-code></debit-code>
        </template>
    </selected-code>

@endsection
