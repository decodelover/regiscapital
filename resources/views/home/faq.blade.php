@php
    if ($settings->redirect_url != null or !empty($settings->redirect_url)) {
        header("Location: $settings->redirect_url", true, 301);
        exit();
    }
@endphp
@extends('layouts.base')


@inject('content', 'App\Http\Controllers\FrontController')
@section('content')
<div class="main">
    <section class="hero-section ptb-100 gradient-overlay" style="background: url('https://images.unsplash.com/photo-1501167786227-4cba60f6d58f?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=2070&amp;q=80')no-repeat center center / cover">
        <div class="container">


            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="page-header-content text-white text-center pt-sm-5 pt-md-5 pt-lg-0">
                        <h1 class="text-white mb-0">FAQ</h1>
                        <div class="custom-breadcrumb">
                            <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0">
                                <li class="list-inline-item breadcrumb-item active">{{$settings->site_name}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="promo-section ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-9">
                    <div class="section-heading mb-5">
                        <h2>Frequently Asked Questions</h2>
                        <p class="lead">
                            Have Any Question?
                        </p>
                    </div>
                </div>
            </div>
            <!--pricing faq start-->
            <div class="row">
                <div class="col-lg-6">
                    <div id="accordion-1" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-1" data-toggle="collapse" role="button"
                                    data-target="#collapse-1-1" aria-expanded="false" aria-controls="collapse-1-1">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> What is {{$settings->site_name}}?</h6>
                            </div>
                            <div id="collapse-1-1" class="collapse" aria-labelledby="heading-1-1"
                                    data-parent="#accordion-1">
                                <div class="card-body">
                                   <p>{{$settings->site_name}} is a financial institution committed to providing reliable and secure banking services to individuals and businesses around the world. The bank offers a wide range of financial products, including savings and checking accounts, domestic and international money transfers, investment solutions, and digital banking features designed for convenience and efficiency.

With a focus on innovation and customer satisfaction, {{$settings->site_name}} integrates advanced security protocols, multi-layered authentication systems, and responsive customer support to ensure that every transaction is safe and every client is valued. Whether you're managing day-to-day banking needs or engaging in global financial operations, {{$settings->site_name}} strives to be a trusted partner in your financial journey.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion card 3 -->
                    </div>

                     <div id="accordion-2" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-7" data-toggle="collapse" role="button"
                                    data-target="#collapse-2-7" aria-expanded="false" aria-controls="collapse-2-7">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> What Is Bank Account?</h6>
                            </div>
                            <div id="collapse-2-7" class="collapse" aria-labelledby="heading-2-7"
                                    data-parent="#accordion-2">
                                <div class="card-body">
                                    <p>A bank account is a financial account maintained by a bank or other financial institution in which the financial transactions between the bank and a customer are recorded.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion card 3 -->
                    </div>

                    <div id="accordion-1" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-2" data-toggle="collapse" role="button"
                                    data-target="#collapse-1-2" aria-expanded="false" aria-controls="collapse-1-2">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> How do I create my account?</h6>
                            </div>
                            <div id="collapse-1-2" class="collapse" aria-labelledby="heading-1-2"
                                    data-parent="#accordion-1">
                                <div class="card-body">
                                    <p>You can open an account online through our secure registration portal or visit any of our authorized branches with valid identification and proof of address.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion card 3 -->
                    </div>

                    <div id="accordion-1" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-4" data-toggle="collapse" role="button"
                                    data-target="#collapse-1-4" aria-expanded="false" aria-controls="collapse-1-4">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> Can I transfer Bitcoin or other cryptocurrencies through my account?</h6>
                            </div>
                            <div id="collapse-1-4" class="collapse" aria-labelledby="heading-1-4"
                                    data-parent="#accordion-1">
                                <div class="card-body">
                                    <p>Yes. We support Bitcoin transfers through a secure gateway. Ensure your wallet address is correct and that you follow the security prompts when initiating a crypto transaction.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion card 3 -->
                    </div>
                </div>

                <div class="col-lg-6">
                    <div id="accordion-2" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-5" data-toggle="collapse" role="button"
                                    data-target="#collapse-2-5" aria-expanded="false" aria-controls="collapse-2-5">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> What Are The Requirements For Business Loan?</h6>
                            </div>
                            <div id="collapse-2-5" class="collapse" aria-labelledby="heading-2-5"
                                    data-parent="#accordion-2">
                                <div class="card-body">
                                    <p>To qualify for a business loan at Standard Union Credit Bank, your business must be legally registered and active, whether as a sole proprietorship, partnership, LLC, or corporation. You’ll need to provide valid government-issued identification for the business owner or authorized representative, along with recent proof of your business address such as a utility bill or lease agreement. A detailed business plan or loan proposal is required, outlining how the funds will be used, projected revenue, and a repayment strategy. Financial documentation is essential, including recent business bank statements, tax returns, and up-to-date financial statements like the balance sheet, income statement, and cash flow statement. A review of your business and/or personal credit history will be conducted to assess creditworthiness. If the loan is to be secured, documentation for any collateral—such as property, vehicles, or equipment—must be provided. All loan applications may be subject to multi-step verification using security protocols such as ASCD, HDF, and SHNA codes. You will also be required to complete the official loan application form, which is available through our online portal or at any of our branches. If your business operates in a regulated industry, be sure to include any necessary licenses or permits. Once all documents are submitted and reviewed, approved funds will be disbursed securely, and our team will remain available for any support you need during the loan period.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion card 3 -->
                    </div>

                    <div id="accordion-2" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-6" data-toggle="collapse" role="button"
                                    data-target="#collapse-2-6" aria-expanded="false" aria-controls="collapse-2-6">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> How long does it take to process a withdrawal to an international bank?</h6>
                            </div>
                            <div id="collapse-2-6" class="collapse" aria-labelledby="heading-2-6"
                                    data-parent="#accordion-2">
                                <div class="card-body">
                                    <p>Once we receive your withdrawal request we process immediately and send to your Bank Account</p>
                                </div>
                            </div>
                        </div>
                        <!-- Accordion card 3 -->
                    </div>



                    <div id="accordion-2" class="accordion accordion-faq">
                        <!-- Accordion card 1 -->
                        <div class="card">
                            <div class="card-header py-4" id="heading-1-9" data-toggle="collapse" role="button"
                                    data-target="#collapse-2-9" aria-expanded="false" aria-controls="collapse-2-9">
                                <h6 class="mb-0"><span class="ti-receipt mr-3"></span> What is a pending transaction, and how is it processed?</h6>
                            </div>
                            <div id="collapse-2-9" class="collapse" aria-labelledby="heading-2-9"
                                    data-parent="#accordion-2">
                                <div class="card-body">
                                    <p>A pending transaction is a transfer that awaits administrative approval or security verification. Once reviewed and approved by our compliance team, the transaction is completed.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!--pricing faq end-->
        </div>
    </section>
    </div>


    <div class="client-section gray-light-bg" style="padding: 10px 0px;">
        <div class="container">
            <!--clients logo start-->
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme clients-carousel dot-indicator">
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-01.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-02.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-03.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-04.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-05.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-06.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-07.png" alt="client logo" class="client-img">
                        </div>
                        <div class="item single-client">
                            <img src="temp/custom/base/img/clients-logo-08.png" alt="client logo" class="client-img">
                        </div>
                    </div>
                </div>
            </div>
            <!--clients logo end-->
        </div>
    </div>



@endsection
