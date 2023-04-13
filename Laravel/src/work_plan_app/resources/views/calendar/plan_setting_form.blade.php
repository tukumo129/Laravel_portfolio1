@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">{{ $calendar->getTitle() }}の勤怠予定設定</div>
               <div class="card-body">
					@if (session('status'))
                       <div class="alert alert-success" role="alert">
                           {{ session('status') }}
                       </div>
                   @endif
					<form method="post" action="{{ route('update_plan_setting') }}">
						@csrf
						<div class="card-body">
							{!! $calendar->render() !!}
							<div class="text-center">
								<button type="submit" class="btn btn-primary">保存</button>
							</div>
						</div>
						
					</form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection