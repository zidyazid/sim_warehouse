@include('components.header')
		<!-- NAVBAR -->
		@include('components.navbar')
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		@include('components.sidebar')
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							@yield('title')
						</div>
						<div class="panel-body">
							@yield('content')
						</div>
					</div>
					<!-- END OVERVIEW -->
					<div class="row">
				    </div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
@include('components.footer')