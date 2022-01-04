@extends('message::layouts.master')

@section('content')
<div class="messaging-page">
    <div class="inbox-wrapper py-2 px-4">
        <div class="p-2">
            <h4>Recent</h4>
        </div>
        <div class="inbox-list">
            {{-- active_chat --}}
            <inbox-list :user="{{ $user }}"></inbox-list>
        </div>
    </div>
    <chatbox :user="{{ $user }}" :vendor-user-id="{{ auth()->id() }}" :chat-room="{{ $chatRoom }}"></chatbox>
</div>
@endsection
