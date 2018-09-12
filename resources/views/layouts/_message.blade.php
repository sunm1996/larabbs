@if (Session::has('message'))
   <div class="alert alert-info">
       <buton type="button" class="close" data-dismiss="alert" aria-hidden="true">x</buton>
       {{ Session::get('message') }}
   </div>

@endif

@if(Session::has('success'))
   <div class="alert alert-success">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
       {{ Session::get('success') }}
   </div>
@endif

@if(Session::has('danger'))
   <div class="alert alert-danger">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
       {{ Session::get('danger') }}
   </div>
@endif
