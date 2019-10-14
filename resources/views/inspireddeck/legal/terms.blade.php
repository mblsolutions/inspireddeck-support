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
        <div class="px-5 py-3 border-b-4 border-brand-blue-100 text-gray-600 text-sm">
            <p>
                {!! $settings['data']['terms_of_service'] !!}
            </p>
        </div>
    </div>


@endsection
