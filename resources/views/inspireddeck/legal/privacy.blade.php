@extends('inspireddeck.layouts.app')

@section('sub-navigation')
    @include('navigation.brand')
@endsection

@section('content')

    @include('inspireddeck.helpers.section-head', [
        'icon' => 'policy',
        'title' => 'Privacy Policy',
        'description' => 'Inspired Deck Privacy Policy',
    ])

    <div class="section-panel">
        <div class="section-row">
            <h1>Privacy Policy</h1>
        </div>
    </div>

@endsection
