<x-guest-layout>


<div class="container  d-flex align-items-center" style="min-height: 100vh;">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{ asset('img/logo_full.png') }}" style="height: 120px; width:auto;">
            <h1 class="orange">A Global Platform that links people, skills and projects across the UN System</h1>
            <p class="grey">The vision of conecta is a global platform that links people, skills and projects across the UN system. conecta gives UN system employees the opportunity to connect with colleagues through collaboration on projects, mentoring, job shadowing and cross-assignments based on their interests and unique skills and talents.</p>
        </div>
        <div class="col-sm-5 offset-sm-1">
            <h4 class="light-grey">Forgot Password</h4>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Go back to login
                </a>
            </div>
            <div class="card pt-0 mt-3">
                <div class="card-body" id="mentors">

                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-floating mt-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" :value="old('email')" required autofocus>
                            <label for="email">Email Address</label>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            

                            <x-button class="btn btn-primary btn-lg" >
                                {{ __('Email Password Reset Link') }}
                            </x-button>
                        </div>


                       
                    </form>
                    


                </div>
            </div>
        </div>
    </div>
</div>



        
</x-guest-layout>
