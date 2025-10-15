<x-guest-layout>


<div class="container  d-flex align-items-center" style="min-height: 100vh;">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{ asset('img/logo_full.png') }}" style="height: 120px; width:auto;">
            <h1 class="orange">A Global Platform that links people, skills and projects across the UN System</h1>
            <p class="grey">The vision of conecta is a global platform that links people, skills and projects across the UN system. conecta gives UN system employees the opportunity to connect with colleagues through collaboration on projects, mentoring, job shadowing and cross-assignments based on their interests and unique skills and talents.</p>
        </div>
        <div class="col-sm-5 offset-sm-1">
            <h4 class="light-grey">Reset Password</h4>
          
            <div class="card pt-0 mt-3">
                <div class="card-body" id="mentors">
                    
                   <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                     <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">



                        <div class="form-floating mt-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" value="<?php echo $request->email; ?>" required readonly>
                            <label for="email">Email Address</label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mt-3">

                            <input type="password" class="form-control" id="password" name="password" placeholder="Password"  required autofocus>
                            <label for="password">Password</label>        
                        </div>

                        <div class="form-floating mt-3">

                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"  :value="__('Confirm Password')" >
                            <label for="password_confirmation">Confirm Password</label>        
                        </div>

                         <div class="d-grid gap-2 mt-4">
                            

                            <x-button class="btn btn-primary btn-lg" >
                                {{ __('Reset Password') }}
                            </x-button>
                        </div>


                    </form>
                    


                </div>
            </div>
        </div>
    </div>
</div>



        
</x-guest-layout>


<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
            </a>
        </x-slot>

        
    </x-auth-card>
</x-guest-layout>
