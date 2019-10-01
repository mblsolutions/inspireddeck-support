@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'loop',
                'title' => 'Credit Code',
                'description' => 'Transfer funds to a new code',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <transfer-code></transfer-code>
        </template>
    </selected-code>

@endsection
