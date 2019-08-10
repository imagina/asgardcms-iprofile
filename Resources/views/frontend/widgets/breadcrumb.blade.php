<div class="container">
	<div class="row justify-content-center align-items-center">
		<div class="col-auto text-center">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb bg-transparent mb-0">
					<li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
					{{ $slot }}
				</ol>
			</nav>
		</div>
	</div>
</div>
