@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                     <form-component></form-component>
                     <question-follow-button></question-follow-button>
                </div>

                <div class="card-body">
                     时间线
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
