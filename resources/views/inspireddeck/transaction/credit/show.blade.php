@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'add',
                'title' => 'Credit Code',
                'description' => 'Add funds to code',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <credit-code></credit-code>
        </template>
    </selected-code>

@endsection
