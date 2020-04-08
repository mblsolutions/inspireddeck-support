@extends('inspireddeck.layouts.app')

@section('sub-navigation')
    @include('navigation.settings')
@endsection

@section('content')

    @include('inspireddeck.helpers.section-head', [
        'icon' => 'settings',
        'title' => 'Update Settings',
        'description' => 'Update your Inspired Deck settings'
    ])

    <form action="#" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('inspireddeck.helpers.form-messages')

        <user-settings>
            <template v-slot:avatar>
                <img src="{{ ui_avatar()->getAvatar() }}" class="rounded-full h-24 w-24 flex items-center justify-center mr-2">
            </template>
        </user-settings>
    </form>


@endsection
