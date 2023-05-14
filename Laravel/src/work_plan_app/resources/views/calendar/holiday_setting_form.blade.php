@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">定休日設定</div>
               <div class="card-body">
               	
               	@if (session('status'))
                       <div class="alert alert-success" role="alert">
                           {{ session('status') }}
                       </div>
                   @endif
					<form method="post" action="{{ route('update_holiday_setting') }}">
						@csrf
                        {!! $holidays->render() !!}
						<button type="submit" class="btn btn-primary">保存</button>
					</form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection