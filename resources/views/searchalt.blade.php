<x-app-layout>
<!--     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
 -->

 <div id="main" class="container pb-4">
  <div class="container">
  <div class="row">
    <div class="col-sm-8">

      <div class="card mt-3 pt-0">
        <div class="card-body" id="profiles">
          

          <div class="row">
            <div class="col-sm-12">

               @if($skills==null)
                  <h4 class="light-grey">No Results Found</h4>
              @else
                 <h4 class="light-grey">You might be searching for the following skills</h4>
              <ul class="link-list">
                @foreach($skills as $skill)
                <li><a href="{{ config('app.url') }}/search?term={{ urlencode($skill['name']) }}">{{ $skill['name'] }}</a></li>
                @endforeach 
              @endif 
             

               
              </ul>
            </div>
          </div>


        </div>
      </div>

    

     
    </div>
  </div>
  </div>

</div><!-- /.container -->


</x-app-layout>
