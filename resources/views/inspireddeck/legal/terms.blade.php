@extends('inspireddeck.layouts.app')

@section('sub-navigation')
    @include('navigation.dashboard')
@endsection

@section('content')

    @include('inspireddeck.helpers.section-head', [
        'icon' => 'policy',
        'title' => 'Terms of Service',
        'description' => 'Inspired Deck Terms of Service',
    ])

    <div class="section-panel">
        <div class="section-row">
            <h1>Terms of Service</h1>

            <p>
                {!! $settings['data']['terms_of_service'] !!}
            </p>
        </div>
    </div>

@endsection
