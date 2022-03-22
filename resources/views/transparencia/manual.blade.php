@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 20px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 15px;"><strong>MANUAIS</strong></h3>
			<h3 style="font-size: 12px;"></h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="d-flex justify-content-between">
		@foreach($manuais as $manual)
		<div class="col-md-2 col-sm-12">
			<div class="card-group">
				<div class="card border-0" style="max-width: 12rem; background-color: #fafafa;">
					<img class="card-img-top border border-secondary" src="{{asset('storage/')}}/{{$manual->path_img}}" alt="Card image cap">
					<div class="card-body text-center" style="padding-top: 5px;">
						<a href="{{asset('storage/')}}/{{$manual->path_file}}" class="badge badge-primary">Download</a>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	</div>
</div>
@endsection