@extends('layouts.app')

@section('sub-navigation')
    @include('navigation.transaction')
@endsection

@section('content')

    @include('helpers.section-head', [
        'icon' => 'search',
        'title' => 'Find Code Results',
        'description' => 'Code results for ' . request()->get('customer')
    ])

    <div class="section-panel">
        @include('helpers.form-messages')
    </div>

    <div class="section-panel">
        @forelse ($results['data'] as $code)

            <div class="section-row">
                <div class="section-icon">
                    <i class="material-icons material-section-icon">credit_card</i>
                    <span class="section-icon-pill
                        @if($code['status'] === 'active')
                            bg-teal-500
                        @elseif ($code['status'] === 'inactive')
                            bg-brand-blue-500
                        @else
                            bg-brand-error-500
                        @endif">
                        {{ $code['status'] }}
                    </span>
                </div>
                <div class="w-4/6 ml-6 pt-1">
                    <h4 class="section-title">
                        <a href="{{ route('product.code.show', ['code' => $code['serial']]) }}">{{ $code['serial'] }}</a> <span class="font-normal text-gray-500">- {{ $code['display'] }}</span>
                    </h4>
                    <div class="section-description mt-0">
                        <span class="block text-sm  font-bold -mt-2">
                            <span class="block text-sm text-gray-500 font-bold -mt-2">
                                @if (isset($code['customer']))
                                    <span class="text-brand-blue-300">{{ $code['customer']['name'] }}</span>
                                @endif
                            </span>
                        </span>
                        <span class="block text-sm">
                            <span class="block text-sm text-gray-500">
                                @if (isset($code['customer']))
                                    <span class="text-gray-600">Address:</span>

                                    @if($code['customer']['address_1'] || $code['customer']['postcode']) {{ $code['customer']['address_1'] }} {{ $code['customer']['postcode'] }} @else Not Supplied @endif |
                                    <span class="text-gray-600">D.O.B:</span>
                                    @if($code['customer']['date_of_birth']) {{ $code['customer']['date_of_birth'] }} @else Not Supplied @endif
                                @endif
                            </span>
                        </span>
                    </div>
                </div>
                <div class="w-2/6 justify-end text-right">
                    <a href="{{ route('inspireddeck.code.search.select', ['serial' => $code['serial']]) }}" class="brand-btn hidden md:inline-block">
                        View Code
                    </a>
                </div>
            </div>
        @empty
            @include('helpers.no-results-panel', [
                'icon' => 'search',
                'heading' => 'Looks like there are no search results',
                'description' => 'Please try again'
            ])
        @endforelse
    </div>

@endsection
