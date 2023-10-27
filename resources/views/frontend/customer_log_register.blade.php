@extends('frontend.master')
@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
			<div class="gray py-3">
				<div class="container">
					<div class="row">
						<div class="colxl-12 col-lg-12 col-md-12">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item"><a href="#">Pages</a></li>
									<li class="breadcrumb-item active" aria-current="page">Login</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ======================= Top Breadcrubms ======================== -->

			<!-- ======================= Login Detail ======================== -->
			<section class="middle">
				<div class="container">
					<div class="row align-items-start justify-content-between">

						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="mb-3">
								<h3>Login</h3>
							</div>
                            @if (session('verify'))
                                <div class="alert alert-danger">{{ session('verify') }} <a href="{{ route('email_verify_req') }}" class="badge badge-info float-right py-2">Email Verify Request</a></div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if (session('login'))
                                <div class="alert alert-warning">{{ session('login') }}</div>
                            @endif
							<form class="border p-3 rounded" action="{{ route('customer.login') }}" method="POST">
                                @csrf
								<div class="form-group">
									<label>Email *</label>
									<input type="text" name="email" class="form-control" placeholder="Email*">
                                    @error('email')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
								</div>

								<div class="form-group">
									<label>Password *</label>
									<input type="password" name="password" class="form-control" placeholder="Password*">
                                    @error('password')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
								</div>

								<div class="form-group">
									<div class="d-flex align-items-center justify-content-between">
										<div class="eltio_k2">
											<a href="{{ route('forgot.password') }}">Lost Your Password?</a>
										</div>
									</div>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
								</div>
							</form>
						</div>

						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
							<div class="mb-3">
								<h3>Register</h3>
							</div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
							<form class="border p-3 rounded" action="{{ route('customer.register') }}" method="POST">
                                @csrf
								<div class="row">
									<div class="form-group col-md-12">
										<label>Full Name *</label>
										<input type="text" name="name" class="form-control" placeholder="Full Name">
									</div>
								</div>

								<div class="form-group">
									<label>Email *</label>
									<input type="text" name="email" class="form-control" placeholder="Email*">
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label>Password *</label>
										<input type="password" name="password" class="form-control" placeholder="Password*">
									</div>

									<div class="form-group col-md-6">
										<label>Confirm Password *</label>
										<input type="password" class="form-control" placeholder="Confirm Password*">
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
								</div>
							</form>
						</div>

					</div>
				</div>
			</section>
			<!-- ======================= Login End ======================== -->
@endsection
