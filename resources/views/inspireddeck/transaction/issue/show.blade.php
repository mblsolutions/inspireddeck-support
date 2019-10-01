@extends('layouts.transaction')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    <selected-code>
        <template v-slot:header>
            @include('helpers.section-head', [
                'icon' => 'play_circle_filled',
                'title' => 'Issue Code',
                'description' => 'Issue a code',
                'url' => route('transaction.index'),
                'button' => 'Go Back'
            ])
        </template>
        <template v-slot:transaction>
            <issue-code></issue-code>
        </template>
    </selected-code>

@endsection
