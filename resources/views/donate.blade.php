@extends('layouts.app')

@section('content')
    <div id="main" class="">
<div class="container">
        <div class="pad"></div>
        <div class="main-content main-detail">
            <div id="bread">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="active">Donate</li>
                </ol>
            </div>
            <div class="profiles-wrap donate">
                <div class="pp-main">
                    <div class="ppm-head ppm-donate">
                        <div class="ppmh-title"><i class="fa fa-gift mr5"></i> Donate</div>
                    </div>
                    <div class="ppm-content donate-content">
                        <div class="donate-desc">
                            <div class="desc">
                                <h4>Dear our valued users,</h4>

                                <p>To bring you the best experience with us, GoMovies has upgraded our website as well as put a lot of efforts in updating the most up-to-date, interesting movies with a quality as high as possible. Recently, due to various objective reasons such as movie deletion, DDOS attack, links stolen by other websites, etc, we have encountered a lot of difficulties. However, we have always stuck to our original criteria of supplying you with a free movie streaming, and in order to do it, we have tried our best to maintain the website. The movies are free, but unfortunately, the server is not. It will be highly appreciated if you can consider a donation. We rely on your generosity for support to get more funding for our service improvement as well as more stable operation.</p>
<!--                                <ul class="dd-list">-->
<!--                                    <li><h4>Become Vip</h4></li>-->
<!--                                    <li>-->
<!--                                        <i class="fa fa-check-circle mr10"></i><span>Sed ut perspiciatis unde omnis iste</span>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <i class="fa fa-check-circle mr10"></i><span>Sed ut perspiciatis unde omnis iste</span>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <i class="fa fa-check-circle mr10"></i><span>Sed ut perspiciatis unde omnis iste</span>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <i class="fa fa-check-circle mr10"></i><span>Sed ut perspiciatis unde omnis iste</span>-->
<!--                                    </li>-->
<!--                                </ul>-->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="donate-block-ul">
<!--                            <div class="block-padding donate-block text-center">-->
<!--                                <a href="#" class="donate-logo"><img src="--><!--?//= base_url() ?--><!--assets/images/bitcoin.png"-->
<!--                                                                     alt=""></a>-->
<!---->
<!--                                <p class="title">Bitcoin</p>-->
<!---->
<!---->
<!--                                <a data-target="#donate-bitcoin" data-toggle="modal" class="btn btn-block btn-warning">Donate-->
<!--                                    via Bitcoin</a>-->
<!--                            </div>-->
                            <div class="block-padding donate-block text-center">
                                <a href="#" class="donate-logo"><img src="https://gomovies.to/assets/images/paypal.png" alt=""></a>

                                <p class="title">Paypal</p>


                                <a data-target="#donate-paypal" data-toggle="modal" class="btn btn-block btn-primary">Donate
                                    via Paypal</a>
                            </div>
<!--                            <div class="block-padding donate-block text-center">-->
<!--                                <a href="#" class="donate-logo"><img src="--><!--?//= base_url() ?--><!--assets/images/offer.png"-->
<!--                                                                     alt=""></a>-->
<!---->
<!--                                <p class="title">Complete an Offer</p>-->
<!---->
<!---->
<!--                                <a data-target="#donate-offer" data-toggle="modal" class="btn btn-block btn-danger">Donate-->
<!--                                    via Offer</a>-->
<!--                            </div>-->
                            <div class="block-padding donate-block text-center">
                                <a href="#" class="donate-logo"><img src="https://gomovies.to/assets/images/amazon.png" alt=""></a>

                                <p class="title">Amazon</p>


                                <a data-target="#donate-amazon" data-toggle="modal" class="btn btn-block btn-default">Donate
                                    via Amazon</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    </div>
@endsection
