@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Serviços</h2>
                    <div class="bt-option">
                        <a href="{{ url('/') }}">Home</a>
                        <span>Serviços</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Coming Soon Section Begin -->
<section class="coming-soon-section spad" style="background: #0a0a0a;
	padding-bottom: 70px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="breadcrumb-text" >
                    <h2 >Em Breve</h2>
                    <h3>Estamos preparando algo incrível para você. Fique atento!</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Coming Soon Section End -->
@endsection
