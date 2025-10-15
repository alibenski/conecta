<x-guest-layout>


<div class="container  d-flex align-items-center" style="min-height: 100vh;">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{ asset('img/logo_full.png') }}" style="height: 120px; width:auto;">
            <h1 class="orange">A Global Platform that links people, skills and projects across the UN System</h1>
            <p class="grey">The vision of conecta is a global platform that links people, skills and projects across the UN system. conecta gives UN system employees the opportunity to connect with colleagues through collaboration on projects, mentoring, job shadowing and cross-assignments based on their interests and unique skills and talents.</p>
        </div>
        <div class="col-sm-5 offset-sm-1">
            <div class="card pt-0">
                <div class="card-body" id="mentors">

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->

                        <div class="form-floating mt-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" :value="old('email')" required autofocus>
                            <label for="email">Email Address</label>
                        </div>

                        <div class="form-floating mt-3">
                            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter Password" />
                            <label for="password">Password</label>
                        </div>

                        <div class="row  mt-4">
                            <div class="col-sm-6">


                                <!-- Remember Me -->
                                <div class="block">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 justify-end justify-content-md-end d-grid gap-2 d-md-flex">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>


                        <div class="d-grid gap-2 mt-4">
                            

                            <x-button class="btn btn-primary btn-lg" >
                                {{ __('Login') }}
                            </x-button>
                        </div>

                        <div class="mt-3 text-center">
                            

                            <a href="<?php echo config('app.url'); ?>/register">Not yet registered?</a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
