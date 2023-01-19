@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
@php
    print_r($upload->order);
@endphp
<div class="w-[900px] py-10">
    <div class="">
        p. {{ }}
    </div>
</div>
@endsection
