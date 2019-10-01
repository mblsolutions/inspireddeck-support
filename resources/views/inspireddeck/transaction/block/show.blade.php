@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'block',
                'title' => 'Block Code',
                'description' => 'Block code to prevent further use',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <block-code></block-code>
        </template>
    </selected-code>

@endsection
