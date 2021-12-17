@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-warning" role="alert">
        {{\Illuminate\Support\Facades\Session::get('success')}}
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('error'))
    <div class="alert alert-warning" role="alert">
        {{\Illuminate\Support\Facades\Session::get('error')}}
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('warning'))
    <div class="alert alert-warning"  role="alert">
            {{\Illuminate\Support\Facades\Session::get('warning')}}
    </div>
@endif
