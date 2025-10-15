<x-guest-layout>


<div class="container d-flex align-items-center" style="min-height: 100vh;">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{ asset('img/logo_full.png') }}" style="height: 120px; width:auto;">
            <h1 class="orange">A Global Platform that links people, skills and projects across the UN System</h1>
            <p class="grey">The vision of conecta is a global platform that links people, skills and projects across the UN system. conecta gives UN system employees the opportunity to connect with colleagues through collaboration on projects, mentoring, job shadowing and cross-assignments based on their interests and unique skills and talents.</p>
        </div>
        <div class="col-sm-5 offset-sm-1">
            <h4 class="light-grey">Register to Conecta</h4>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
            <div class="card mt-3 pt-0">
                <div class="card-body" id="mentors">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    
                    <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
    
                    <div class="form-floating mt-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" :value="old('email')" required autofocus>
                        <label for="email">Email Address</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Enter Password" />
                        <label for="password">Password</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required placeholder="Confirm Passowrd" />
                        <label for="password">Confirm Password</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" required autofocus>
                        <label for="firstname">First Name</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" required>
                        <label for="lastname">Last Name</label>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                            

                        <x-button class="btn btn-primary btn-lg" >
                            {{ __('Register') }}
                        </x-button>
                    </div>

                    
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
