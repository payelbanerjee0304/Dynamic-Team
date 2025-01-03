@extends('layouts.layout')

@section('content')
<style>

    body{
        background: url(../images/image1.png) no-repeat;
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
    }
    .btn{
        font-size: medium;
    }
</style>
    <div class="otr">
        <div class="container">
            <div class="south_jst">
                <div class="top_hdr">
                    <div class="logo">
                        {{-- <img src="{{ asset('images/logo.png') }}" /> --}}
                    </div>
                    <div class="top_h">
                        <h2>flexiForms Pro<br/> Reflects seamless team building and form integration</h2>
                        
                    </div>
                </div>
                <div class="mul_form">
                    <div class="multi_top_dir">Thank You</div>
                    {{-- <a href="{{route('add-member-session')}}"><button class="btn btn-secondary">Back</button></a>
                    <a href="{{route('logout')}}"><button class="btn btn-info">Logout</button></a> --}}
                    <div class="progress_bar" style="color: red">
                        Your Details Submitted Successfully
                    </div>

                    

                </div>
            </div>
        </div>
    </div>


@endsection
