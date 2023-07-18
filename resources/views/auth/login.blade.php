@php
/**
 * Author: Cas Rovers
 * Date:   11-7-2023
 * File:   login.blade.php
 **/
@endphp
@extends('layout')

@section('title', 'Login')

@section('content')
    <div class="container">
        <h2>Login</h2>
        <form action="{{ route('login.post') }}" method="post">
            <div class="mt-5">
                @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error )
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            @csrf
            <div>
                <label for="email">E-mail</label>
                <input type="text" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="text" id="password" name="password" placeholder="Pasword">
                <span toggle="#password"></span>
            </div>
            <div>
                <input type="submit" id="loginBtn" value="Login">
            </div>
        </form>
    </div>
@endsection
