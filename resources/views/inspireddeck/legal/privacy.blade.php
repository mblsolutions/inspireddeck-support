@extends('inspireddeck.layouts.app')

@section('sub-navigation')
    @include('navigation.dashboard')
@endsection

@section('content')

    @include('inspireddeck.helpers.section-head', [
        'icon' => 'policy',
        'title' => 'Privacy Policy',
        'description' => 'Inspired Deck Privacy Policy',
    ])

    <div class="section-panel">
        <div class="markdown-contents">
            {!! $contents !!}
        </div>
    </div>

@endsection
