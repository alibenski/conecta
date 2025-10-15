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

                    <h4 class="light-grey">Successful Verification</h4>
                    <div class="mb-4 text-sm text-gray-600">
                        Your account is now verified. Please login to start using Conecta.
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg" >Login</a>


                   
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
