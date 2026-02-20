@php
    if ($settings->redirect_url != null or !empty($settings->redirect_url)) {
        header("Location: $settings->redirect_url", true, 301);
        exit();
    }
@endphp

@extends('layouts.base')
@section('title', 'Terms and Privacy And Policy')
@section('styles')
@parent
@endsection
@inject('content', 'App\Http\Controllers\FrontController')
@section('content')
<div class="main">
    <!-- START SECTION BANNER -->
    <section class="hero-section ptb-100 gradient-overlay" style="background: url('https://images.unsplash.com/photo-1501167786227-4cba60f6d58f?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=2070&amp;q=80')no-repeat center center / cover">
        <div class="container">


            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="page-header-content text-white text-center pt-sm-5 pt-md-5 pt-lg-0">
                        <h1 class="text-white mb-0">Privacy Policy</h1>
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


    <section class="about-us-section ptb-100">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-12 col-lg-12">
                    <div class="video-promo-content mb-md-4 mb-lg-0">
                        <h2 class="text-center">Information Collection</h2>
                        <p> {{$settings->site_name}} Limited (the “Bank”) intends to provide you with quality services in order to meet your expectations. The Bank realizes the importance of the protection of your personal data and compliance with relevant laws and regulations. The Bank has provided this Privacy Notice to inform you of personal data protection and your rights as the data subject of personal data. The Bank would like to inform you, as the data subject, who we are <br><br>

                        The Bank would like to inform you, as the data subject, who we are <br><br>

                        <li>(1) a person interacting with the Bank whether you are a current, former or prospective customer of the Bank, or</li>
                        <li>(2) an employee, staff, officer, representative, shareholder, director, contact person, agent, or a person related to a juristic person or a person as mentioned in (1) above, a trust or a group of persons interacting with the Bank, whether it is a current, former, or prospective customer of the Bank, about the protection of your personal data that the Bank obtains or will obtain from business operation and service provisions through branches, websites, telephones, electronic channels, applications, social media or other sources, to ensure you that the Bank will maintain your personal data and will collect, use or disclose your personal data where the Bank deems necessary, accurate and appropriate, and to notify you of your rights as the data subject of personal data as specified in this Privacy Notice.</li><br><br>
                    </div>

                    <div class="video-promo-content mb-md-4 mb-lg-0">
                        <h2 class="text-center">How We Use Cookies</h2>
                        <p> {{$settings->site_name}} Limited (the “Bank”) uses Cookies or other similar technologies on the Bank’s website in order to provide you with a better experience from use of website and to help the Bank to improve the Bank's website service quality to better meet your preference.<br>

                        <li>Functional Cookies – These Cookies will remember you during website visit and personalization to facilitate you when you are back to use the website again.</li>

                        <li>Analytic/Performance Cookies – These Cookies will enable the Bank to analyze or evaluate website performance and to understand your interest in order to manage, improve and better the Bank’s website.</li><br>

                        <li>Advertising Cookies – These Cookies will remember your personalized setting for use of the Bank’s website and will use the information for webpage customization to set up, modify and properly introduce information or advertisement to suit your interest and preference. </li><br>

                        <li>Highly professional administration.</li>
                    </div>

                    <div class="video-promo-content mb-md-4 mb-lg-0">
                        <h2 class="text-center">Data Protection</h2>
                        <p>The Bank will automatically collect your website visit information through Cookies such as: Internet Domain and IP Number or Internet Protocol Address (IP Address) from the website access point Types of browser software including structure and operating system used for accessing to the Bank’s website Date and time you access to the Bank’s website </p><br>

                       <p>Other website address which you use to connect to the Bank’s website or leave the Bank’s website Total number of the Bank’s website visitors, website visitor behavior, total number of website pages you access, web sessions and website information you visit Preferred language and recent keyword search you used Such website visit information will not be disclosed or be personal identifiable to you and will not contain any personal specific information. </p>
                    </div>

                    <div class="video-promo-content mb-md-4 mb-lg-0">
                        <h2 class="text-center">Our Policy For Age Under 18</h2>
                        <p>State laws and corporate policies vary, but banks are often reluctant to open accounts for anybody under age 18 unless there's also an adult on the account. </p>
                    </div>


                </div>
            </div>
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

@section('scripts')
@parent

@endsection
