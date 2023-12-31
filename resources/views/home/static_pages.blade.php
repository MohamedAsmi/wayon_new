@extends('template')
@section('main')
<div class="container-fluid container-fluid-90 min-height cont">
    {!! $content !!}
</div>
<br>
@stop

<style>
    .cont{
        padding-top: 120px;
    }
</style>