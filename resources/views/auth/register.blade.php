@php
    /**
     * Author: Cas Rovers
     * Date:   11-7-2023
     * File:   register.blade.php
    **/
@endphp
@extends('layout')

@section('title', 'Register')

@section('content')
    <div class="container">
        <h2>Register</h2>
        <form action="{{ route('register.post') }}" method="post">
            @csrf
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
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

            <div>
                <label for="nameInput">Name</label>
                <input id="nameInput" name="name" type="text" placeholder="Name" value="{{ old('name') }}" autofocus>
            </div>
            <div>
                <label for="emailInput">E-mail</label>
                <input id="emailInput" name="email" type="email" placeholder="E-mail" value="{{ old('email') }}">
            </div>
            <div>
                <label for="passwordInput">Password</label>
                <input type="password" id="passwordInput" name="password" placeholder="Password">
                <span toggle="#passwordInput"></span>
            </div>
            <div>
                <label for="passwordConfirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                <span toggle="#password_confirmation"></span>
            </div>
            <div>
                <input type="submit" id="registerBtn" value="submit">
            </div>
            <p class="loginhere">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </p>
        </form>
    </div>
@endsection
