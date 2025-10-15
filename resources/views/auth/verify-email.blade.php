<x-guest-layout>


<div class="container d-flex align-items-center" style="min-height: 100vh;">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{ asset('img/logo_full.png') }}" style="height: 120px; width:auto;">
            <h1 class="orange">A Global Platform that links people, skills and projects across the UN System</h1>
            <p class="grey">The vision of conecta is a global platform that links people, skills and projects across the UN system. conecta gives UN system employees the opportunity to connect with colleagues through collaboration on projects, mentoring, job shadowing and cross-assignments based on their interests and unique skills and talents.</p>
        </div>
        <div class="col-sm-5 offset-sm-1">
            <h4 class="light-grey">Verify your Email</h4>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="card mt-3 pt-0">
                <div class="card-body" id="mentors">
                   <div class="mb-4 text-sm text-gray-600">
                        {{ __('To continue, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between mb-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf

                            <div>
                                <x-button class="btn btn-primary btn-lg" >
                                    {{ __('Resend Verification Email') }}
                                </x-button>
                            </div>
                        </form>

                        
                    </div>
                    <a href="{{ route('logout') }}" style="margin-top:32px;">
                            Logout
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>

