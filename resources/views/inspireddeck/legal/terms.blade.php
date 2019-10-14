@extends('inspireddeck.layouts.app')

@section('sub-navigation')
    @include('navigation.brand')
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
                {{ $settings['data']['privacy_policy'] }}
            </p>
        </div>
    </div>

@endsection
