@extends('layouts.wizard_layout')
@section('title', '')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/wizard_card_css.css') }}">

<style>
    body {
        /*background-color: #EBE9E9; */
        background-color: #F1F1F1;
    }

    .wizard,
    .wizard .nav-tabs,
    .wizard .nav-tabs .nav-item {
        position: relative;
    }

    .wizard .nav-tabs:after {
        content: "";
        width: 80%;
        border-bottom: solid 2px #D8501C;
        position: absolute;
        margin-left: auto;
        margin-right: auto;
        top: 38%;
        z-index: -1;
    }

    .wizard .nav-tabs .nav-item .nav-link {
        width: 70px;
        height: 70px;
        margin-bottom: 6%;
        background: white;
        border: 2px solid #D8501C;
        color: #D8501C;
        z-index: 10;
    }

    .wizard .nav-tabs .nav-item .nav-link:hover {
        color: #07382F;
        border: 2px solid #07382F;
    }

    .wizard .nav-tabs .nav-item .nav-link.active {
        background: #D8501C;
        border: 2px solid #D8501C;
        color: #fff;
    }

    .wizard .nav-tabs .nav-item .nav-link:after {
        content: " ";
        position: absolute;
        left: 50%;
        transform: translate(-50%);
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #D8501C;
        transition: 0.1s ease-in-out;
    }

    .nav-tabs .nav-item .nav-link.active:after {
        content: " ";
        position: absolute;
        left: 50%;
        transform: translate(-50%);
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #D8501C;
    }

    .wizard .nav-tabs .nav-item .nav-link svg {
        font-size: 25px;
    }

    .selectable-card {
        background-color: #ffff;
        box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.11),
            2px 5px 5px #B2BEB5;
    }


    .selectable-card:hover {
        transform: translateY(-5px) scale(1.005) translateZ(0);
        box-shadow: 0 15px 15px rgba(0, 0, 0, 0.11),
            0 10px 10px #D8501C;
        border: 5px solid #D8501C;
    }

    .selectable-card-two {
        background-color: #ffff;
        /* border: 5px solid #B2BEB5; */
        box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.11),
            2px 5px 5px #B2BEB5;
    }

    .selectable-card-two:hover {
        transform: translateY(-5px) scale(1.005) translateZ(0);
        box-shadow: 0 15px 15px rgba(0, 0, 0, 0.11),
            0 10px 10px #D8501C;
        border: 5px solid #D8501C;
        /* background-color: #D8501C; */
    }

    .activate_option {
        transform: scale(1) translateZ(0);
        box-shadow: 0 15px 15px rgba(0, 0, 0, 0.11),
            0 10px 10px #D8501C;
        /* background: #D8501C; */
        border: 5px solid #D8501C;
    }

    .activate_option p {
        color: #fff;
    }

    .option-button {
        border: none;
        outline: none;
        background: none;
    }

    .white_text {
        color: #fff;
    }

    .card p {
        font-size: 17px;
        color: #4C5656;
        margin-top: 30px;
        z-index: 1000;
        transition: color 0.3s ease-out;
    }

    .cards-row {
        column-gap: 40px
    }

    @media(min-width: 1280px) {
        .grind {
            width: 20%;
        }
    }

    .nav-link.active path {
        fill: #fff;
    }

    .dropzone {
        /* border: 2px dashed #ccc; */
        background: #ffff;
        background: #EAE9E9;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        min-height: 100px;
    }

    .dropzone:hover {
        border-color: #0d6efd;
    }

    .dropzone .text {
        font-size: 1.2rem;
        color: #777;
    }


    .flipcard {
        perspective: 1000px;
        margin-bottom: 1.5rem;
        /* border-width: 2px 2px 2px 2px;
        border-style: solid;
        border-color: #999 #B2BEB5; */
    }

    .flipcard .flipcard-wrap {
        position: relative;
        width: 100%;
        height: 70%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .flipcard .card-front,
    .flipcard .card-back {
        width: 100%;
        height: 100%;
        position: relative;
        backface-visibility: hidden;
        transition: all .3s;
    }

    .flipcard .card-front {
        z-index: 2;
    }

    .flipcard .card-front::after {
        content: "";
        display: block;
        width: 0;
        position: absolute;
        bottom: -1px;
        right: -1px;
        border-width: 16px 16px 0 0;
        border-style: solid;
        border-color: #999 #fff;
        border-radius: .25rem 0 0 0;
    }

    .flipcard .card-back {
        position: absolute;
        top: 0;
        text-align: left;
        z-index: 1;
        transform: rotateY(180deg);
        overflow-y: auto;
    }

    /* the flippy magic */
    .flipcard:hover .flipcard-wrap {
        /* transform: rotateY(-180deg); */
    }

    /* Custom position for the icon */
    .card-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
    }

    /* canvas {
        cursor: grab;
    }

    canvas:active {
        cursor: grabbing;
    } */
</style>
<link rel="stylesheet" href="{{ asset('css/3dcss.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropzone_css.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
@include('includes.new_home.buyer_new_header')

<section class="pt-5">
    <div class="container px-2 px-lg-3">
        <div class="container">
            <div class="wizard my-5">
                <ul class="nav nav-tabs justify-content-center border-0 py-3 py-lg-5" id="myTab" role="tablist">
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Step 1">
                        <a class="nav-link active rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step1" id="step1-tab" data-bs-toggle="tab" role="tab" aria-controls="step1" aria-selected="true">
                            <svg width="46" height="50" viewBox="0 0 46 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_151_2321)">
                                    <path d="M43.5536 25.4046C42.5196 25.9852 41.5128 26.6102 40.4526 27.1306C39.0482 27.8203 37.8278 28.7259 36.9074 29.9838C36.1041 31.0803 35.3871 32.2405 34.6314 33.3711C33.7395 34.7062 32.9054 36.0857 31.9373 37.3629C30.8783 38.7616 29.4727 39.7525 27.7921 40.3172C26.6581 40.699 25.9514 40.3877 25.4843 39.2798C24.6014 37.1833 24.7048 35.0642 25.6207 33.0461C27.8649 28.1021 31.6487 24.8932 36.9029 23.4956C38.2608 23.1343 39.6834 23.1536 41.0742 23.4252C42.1594 23.6376 43.0536 24.1467 43.5536 25.4034V25.4046Z" fill="#D8501C" />
                                    <path d="M24.3944 26.0686C21.3219 26.0538 18.7209 24.8016 16.3426 23.0211C13.7644 21.0894 11.7009 18.7282 10.6453 15.6193C9.98966 13.6865 9.96467 11.7548 10.8146 9.8583C11.2237 8.94359 11.9123 8.62543 12.8929 8.92655C14.6314 9.45946 16.0927 10.4514 17.1665 11.89C18.2959 13.4035 19.2686 15.0318 20.3128 16.609C20.8242 17.3817 21.3219 18.1657 21.8605 18.9202C22.8706 20.3315 24.1558 21.4109 25.7318 22.17C26.6647 22.6188 27.5328 23.2029 28.4305 23.7244C28.7759 23.9244 28.7543 24.1653 28.5555 24.471C28.0225 25.2925 27.234 25.7061 26.309 25.8675C25.6784 25.9777 25.033 26.005 24.3932 26.0686H24.3944Z" fill="#D8501C" />
                                    <path d="M14.1735 42.5434C10.4223 42.2957 7.0607 40.6212 4.10697 38.023C2.02232 36.1906 0.621565 33.948 0.101254 31.201C-0.0896024 30.1922 -0.055521 29.2016 0.598844 28.3234C0.86468 27.9667 1.1237 27.8054 1.51564 28.1575C2.06321 28.6506 2.70054 29.063 3.17086 29.6185C4.99877 31.7759 7.39924 32.8597 10.0735 33.4981C11.8571 33.9241 13.6453 34.3502 15.397 34.8864C17.2795 35.4624 18.8972 36.4973 20.1151 38.0878C20.9342 39.1568 20.858 39.9157 19.8447 40.7734C18.2724 42.1026 16.4161 42.5581 14.1724 42.5434H14.1735Z" fill="#D8501C" />
                                    <path d="M17.0145 6.00086C19.6746 6.07699 22.0323 7.04056 24.1936 8.51887C27.1445 10.5381 29.3841 13.1424 30.5454 16.5717C30.9783 17.8523 31.1635 19.1863 31.0636 20.5431C30.9477 22.1146 30.0477 22.7941 28.5524 22.2782C25.7241 21.301 23.347 19.6909 21.8165 17.024C21.0256 15.6468 20.2552 14.2571 19.4439 12.8913C18.2394 10.863 16.5998 9.33018 14.3624 8.47115C13.8943 8.29161 13.4568 8.00186 13.05 7.70188C12.708 7.45076 12.6887 7.17805 13.1398 6.93602C14.3533 6.28834 15.6396 5.98154 17.0145 6.00086Z" fill="#D8501C" />
                                    <path d="M31.684 43.3122C30.3512 43.3168 29.0933 43.0214 27.9252 42.3748C27.457 42.1157 27.4173 41.9032 27.84 41.5817C28.2263 41.2874 28.6558 41.0181 29.1081 40.8454C31.3852 39.9761 33.0419 38.4092 34.2566 36.3388C34.9838 35.0992 35.7054 33.8549 36.386 32.5891C37.795 29.9722 40.046 28.3462 42.7015 27.2224C44.7957 26.3361 45.8729 27.0929 45.849 29.3666C45.816 32.3937 44.6604 34.9992 42.7651 37.299C40.3471 40.2318 37.3598 42.2873 33.5987 43.1111C33.2669 43.1838 32.9283 43.2316 32.5897 43.2679C32.2897 43.2997 31.9852 43.2986 31.6829 43.3134L31.684 43.3122Z" fill="#D8501C" />
                                    <path d="M7.66611 23.9316C13.5954 24.4747 18.2705 27.0514 21.2403 32.3365C22.106 33.8771 22.3877 35.5745 22.1026 37.34C21.9856 38.0637 21.7288 38.1682 21.138 37.7194C20.854 37.5036 20.5723 37.2627 20.3541 36.9832C18.625 34.7712 16.2732 33.6874 13.5898 33.1591C12.0492 32.8557 10.5075 32.5467 8.98854 32.1548C6.39708 31.4856 4.51569 29.7735 2.84562 27.791C2.64226 27.5501 2.49456 27.2491 2.37641 26.9537C2.05489 26.1527 2.2503 25.5086 2.96718 25.0246C4.02376 24.3111 5.25643 24.1691 6.47547 24.0055C6.86856 23.9532 7.26847 23.9555 7.66497 23.9316H7.66611Z" fill="#D8501C" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_151_2321">
                                        <rect width="46" height="38" fill="white" transform="translate(0 6)" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Step 2">
                        <a id="step_2_btn" class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" disabled href="#step2" id="step2-tab" data-bs-toggle="tab" role="tab" aria-controls="step2" aria-selected="false" title="Step 2">
                            <svg width="46" height="50" viewBox="0 0 46 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_151_2323)">
                                    <path d="M8.91113 34.3291C9.68385 32.9236 10.5707 31.6444 11.7579 30.5921C12.9619 29.5244 14.3436 28.7637 15.8922 28.3679C17.7564 27.8904 19.6548 27.7813 21.5753 28.0217C23.2246 28.2281 24.8723 28.4482 26.4584 28.9632C28.964 29.7751 31.2734 30.9519 33.2673 32.7036C34.3725 33.6741 35.2475 34.822 35.8803 36.1404C36.2793 36.971 36.5761 37.8461 36.6239 38.7841C36.6273 38.8472 36.6239 38.9104 36.6239 38.9922C36.5011 38.9666 36.4039 38.9564 36.3118 38.9274C35.2543 38.5845 34.1507 38.5044 33.0609 38.3577C31.1011 38.0951 29.1345 38.136 27.168 38.2656C26.2162 38.3287 25.2663 38.4447 24.3145 38.4942C23.1052 38.5573 21.9113 38.4276 20.7618 38.0353C20.0317 37.7864 19.3086 37.5134 18.5973 37.2149C17.5176 36.7612 16.4176 36.3929 15.2629 36.178C14.7546 36.0825 14.2565 35.9341 13.7534 35.8164C13.4328 35.7413 13.1018 35.7089 12.7914 35.6083C12.261 35.436 11.7305 35.2552 11.2257 35.0216C10.569 34.718 9.89017 34.5167 9.18066 34.3973C9.09368 34.3819 9.00841 34.3547 8.91113 34.3291Z" fill="#D8501C" />
                                    <path d="M7.96613 36.8848C8.16227 36.9496 8.30213 36.9871 8.43517 37.04C9.63937 37.5158 10.8878 37.8211 12.1534 38.0975C13.8965 38.4778 15.6141 38.9605 17.2395 39.7229C18.4335 40.2823 19.6666 40.736 20.9595 41.0123C22.0869 41.2545 23.2142 41.3023 24.3673 41.1709C25.0375 41.0942 25.7352 41.1505 26.4105 41.2255C27.8262 41.3825 29.2333 41.3808 30.649 41.2118C31.7525 41.0806 32.8612 40.9305 33.9715 41.0925C34.7186 41.2016 35.4554 41.3791 36.1957 41.5291C36.2656 41.5428 36.3287 41.582 36.3986 41.611C35.95 42.7555 35.2695 43.7293 34.444 44.6009C32.7332 46.4038 30.6371 47.5568 28.2561 48.2151C26.4976 48.7012 24.7067 48.9007 22.8834 48.8428C21.5547 48.8001 20.2482 48.6091 18.9622 48.2714C16.5113 47.6267 14.2206 46.6426 12.2182 45.0597C10.8606 43.9869 9.76553 42.6924 9.00653 41.1351C8.52557 40.1475 8.16568 39.1174 8.08723 38.007C8.06164 37.6506 8.01047 37.2941 7.96613 36.8848Z" fill="#D8501C" />
                                    <path d="M44.2178 22.9082C44.5709 23.4984 44.8744 24.0663 45.1269 24.6684C45.5789 25.7463 45.8159 26.872 45.8347 28.0301C45.85 29.0245 45.7784 30.024 45.4356 30.974C44.0438 34.8322 41.4905 37.7692 38.1799 40.1042C38.0469 40.198 37.9019 40.2764 37.7382 40.377C37.7262 40.3037 37.7092 40.2526 37.7092 40.2014C37.7705 37.1296 36.5784 34.5882 34.4293 32.4528C34.2689 32.2942 34.2502 32.1782 34.3764 31.9923C35.1491 30.8546 36.0786 29.8688 37.2299 29.1167C38.5654 28.2416 39.7065 27.1569 40.7742 25.9835C41.3865 25.3114 42.0516 24.706 42.8038 24.1857C43.2404 23.8838 43.6106 23.4864 44.008 23.1299C44.0677 23.0753 44.1206 23.0123 44.2195 22.9082H44.2178Z" fill="#D8501C" />
                                    <path d="M2.01153 22.6242C2.53515 22.1467 3.08606 21.7339 3.7052 21.42C5.60353 20.4598 7.61957 20.1852 9.70386 20.4701C10.7425 20.6116 11.7864 20.8111 12.7893 21.1147C14.674 21.6862 16.4102 22.5867 18.0391 23.6987C19.187 24.4816 20.2615 25.3464 21.2013 26.3714C21.3838 26.5693 21.5527 26.7808 21.7557 27.0162C21.4316 27.0162 21.1519 27.0128 20.8704 27.0162C19.8505 27.0298 18.8322 27.0435 17.8123 27.0622C16.8213 27.0792 15.8764 27.342 14.9434 27.6387C13.6472 28.0498 12.4516 28.6655 11.3975 29.5371C11.0837 29.7963 11.0666 29.8014 10.7699 29.5149C9.98522 28.761 9.22452 27.9849 8.43314 27.2396C7.12494 26.0064 5.73146 24.874 4.22029 23.8966C3.51758 23.4429 2.77052 23.0575 2.00983 22.6242H2.01153Z" fill="#D8501C" />
                                    <path d="M18.5834 2C19.0883 2.15862 19.5948 2.31724 20.0997 2.47586C21.7695 3.00119 23.3523 3.72778 24.8686 4.59764C25.8203 5.14344 26.6236 5.85467 27.178 6.81323C27.8926 8.04809 28.1007 9.33241 27.6879 10.7464C27.2786 12.1467 26.523 13.3099 25.5799 14.3844C24.9778 15.07 24.3706 15.7506 23.9135 16.554C23.499 17.2822 23.3352 18.0703 23.2619 18.8855C23.1732 19.8799 23.3455 20.8538 23.5297 21.826C23.5467 21.9181 23.5536 22.0136 23.574 22.1739C23.3523 22.0358 23.1834 21.9402 23.0231 21.8294C21.7746 20.9732 20.6933 19.9481 19.8421 18.6894C19.1514 17.6677 18.991 16.5659 19.281 15.3668C19.5453 14.2787 20.0145 13.2792 20.4578 12.2627C20.8877 11.2785 21.2289 10.2551 21.5921 9.24371C21.9758 8.17089 21.9281 7.10659 21.5427 6.03377C21.0139 4.56183 20.1525 3.33549 18.945 2.34794C18.8205 2.24561 18.6857 2.15862 18.5544 2.06481C18.563 2.04264 18.5715 2.02047 18.58 2H18.5834Z" fill="#D8501C" />
                                    <path d="M42.602 20.9979C42.3342 21.2145 42.0528 21.4141 41.8037 21.6495C41.0447 22.3675 40.2789 23.0788 39.5524 23.8293C38.3909 25.03 37.1168 26.0874 35.7369 27.029C34.4065 27.938 33.2263 29.0074 32.4349 30.4402C32.3206 30.6483 32.2302 30.6653 32.0238 30.5305C30.6695 29.6488 29.2352 28.9187 27.724 28.3474C27.3402 28.2024 26.9411 28.1018 26.5505 27.9739C26.4294 27.9346 26.3134 27.8733 26.1412 27.7965C26.5727 27.162 26.9616 26.5428 27.3965 25.9561C28.6808 24.2216 30.2687 22.8059 32.0972 21.6699C33.7874 20.621 35.609 19.9268 37.6148 19.7699C38.7252 19.6829 39.798 19.8364 40.8401 20.2014C41.4336 20.4095 42.0136 20.6602 42.5986 20.8922C42.6003 20.9263 42.602 20.9587 42.6037 20.9928L42.602 20.9979Z" fill="#D8501C" />
                                    <path d="M0.563634 24.5574C1.68763 25.0759 2.76387 25.6097 3.63885 26.4813C4.57181 27.4109 5.50649 28.3404 6.48892 29.2171C7.04495 29.7135 7.70672 30.087 8.29687 30.5475C8.65167 30.8238 8.96038 31.1615 9.29124 31.4685C9.40207 31.5708 9.40036 31.6646 9.31339 31.7892C9.08824 32.1132 8.8631 32.439 8.66019 32.7767C8.09219 33.7233 7.63509 34.7245 7.26326 35.7615C7.00231 36.4882 7.06371 37.2557 7.06541 38.0113C7.06541 38.0641 7.06541 38.1187 7.06541 38.2193C6.80787 38.0521 6.57761 37.914 6.361 37.7571C4.69803 36.5529 3.25679 35.1339 2.1328 33.4061C1.24417 32.0399 0.59263 30.5645 0.323144 28.9579C0.0980037 27.6138 0.0792417 26.2544 0.434008 24.9156C0.464709 24.7995 0.515877 24.6887 0.563634 24.5557V24.5574Z" fill="#D8501C" />
                                    <path d="M29.366 6.72559C30.0926 6.88591 30.8226 7.02577 31.5424 7.21168C32.3218 7.41295 33.045 7.75236 33.6727 8.26404C34.8359 9.21407 35.1633 10.454 34.9212 11.8987C34.7865 12.7037 34.3771 13.3741 33.9421 14.0342C33.6625 14.4605 33.3435 14.8613 33.0587 15.2843C32.373 16.2991 32.2587 17.4198 32.4804 18.5949C32.547 18.948 32.6203 19.2994 32.7022 19.7155C32.5691 19.6404 32.4838 19.5995 32.4071 19.5467C31.614 19.0009 30.9267 18.3493 30.3399 17.5801C29.7361 16.787 29.6457 15.8966 29.7276 14.9569C29.8146 13.9591 30.3621 13.1353 30.7493 12.25C30.9847 11.7111 31.2047 11.15 31.3223 10.5768C31.5014 9.69505 31.1996 8.88489 30.7373 8.14124C30.4167 7.62615 29.9886 7.20315 29.4684 6.87909C29.424 6.8518 29.3882 6.80745 29.3489 6.77164C29.3558 6.75799 29.3609 6.74434 29.3677 6.7307L29.366 6.72559Z" fill="#D8501C" />
                                    <path d="M15.4475 19.7438C14.68 19.2645 14.0301 18.7579 13.4827 18.1218C13.0836 17.6579 12.7305 17.1683 12.5463 16.5696C12.2785 15.6964 12.3416 14.8402 12.6777 14.0096C12.9915 13.2335 13.3462 12.4728 13.6925 11.7104C14.2348 10.5165 14.1496 8.81085 13.1331 7.73631C12.8089 7.39349 12.4474 7.08648 12.079 6.74023C12.3928 6.80164 12.693 6.85622 12.9932 6.92103C13.8766 7.11206 14.7585 7.29456 15.5721 7.72779C16.7182 8.3401 17.4635 9.24748 17.6955 10.5335C17.8422 11.3471 17.6819 12.1419 17.2998 12.8549C16.9024 13.5985 16.4419 14.3166 15.9421 14.9971C14.9973 16.2849 14.8403 17.6698 15.2838 19.1639C15.335 19.3345 15.3793 19.5067 15.4458 19.7421L15.4475 19.7438Z" fill="#D8501C" />
                                    <path d="M36.7516 40.2213C36.7465 40.4976 36.593 40.6187 36.3815 40.5539C34.9573 40.1207 33.4956 40.078 32.0271 40.148C31.1317 40.1906 30.2396 40.3032 29.3441 40.3373C28.3004 40.3765 27.2531 40.3952 26.2092 40.3612C25.1398 40.3253 24.0704 40.2486 23.0078 40.1292C22.0698 40.0234 21.1402 39.8375 20.2073 39.684C19.2299 39.5254 18.3498 39.0905 17.4509 38.7084C16.0797 38.1251 14.6759 37.6407 13.2074 37.3541C12.6753 37.2501 12.1602 37.0488 11.6263 36.9704C10.6729 36.8289 9.79619 36.4485 8.88539 36.1756C8.66365 36.1091 8.5409 35.959 8.50677 35.7355C8.4573 35.4217 8.63469 35.2461 8.93318 35.345C9.68877 35.5957 10.4324 35.8771 11.1896 36.121C11.9095 36.353 12.6326 36.573 13.3643 36.7589C14.3434 37.0079 15.3394 37.1955 16.3151 37.4548C16.9172 37.6151 17.5209 37.8078 18.077 38.0859C18.9178 38.5055 19.8252 38.6521 20.7172 38.8653C21.7866 39.1195 22.8765 39.2218 23.9698 39.2644C25.0801 39.3088 26.1905 39.3651 27.3009 39.3532C28.1724 39.3447 29.0405 39.2099 29.9122 39.1843C30.7257 39.1621 31.5495 39.1451 32.3546 39.244C33.586 39.3941 34.8038 39.6414 36.0268 39.8563C36.2109 39.8887 36.3935 39.9518 36.564 40.032C36.6527 40.0729 36.7124 40.1803 36.7516 40.223V40.2213Z" fill="#D8501C" />
                                    <path d="M1.43086 23.4912C1.7464 23.6481 2.06024 23.7897 2.36212 23.9534C5.05016 25.4117 7.27428 27.4482 9.40113 29.6058C9.65532 29.8634 9.92306 30.1073 10.1909 30.3512C10.317 30.4655 10.3461 30.5593 10.2164 30.7009C10.0663 30.8629 10.0015 30.7315 9.90261 30.6463C9.32608 30.1568 8.78541 29.6143 8.15949 29.1982C7.0099 28.4324 6.01895 27.4994 5.07745 26.5085C4.04556 25.4236 2.89428 24.5112 1.52467 23.892C1.45816 23.8613 1.38481 23.8324 1.33194 23.7829C1.28589 23.7402 1.22619 23.6583 1.23983 23.614C1.25519 23.5663 1.34729 23.5407 1.42746 23.4929L1.43086 23.4912Z" fill="#D8501C" />
                                    <path d="M33.4165 31.5953C33.1283 31.261 33.1164 31.2542 33.3245 30.9096C33.7474 30.2086 34.3256 29.6492 34.9805 29.1648C36.4389 28.0834 37.7863 26.8741 39.1184 25.6461C40.2151 24.6364 41.3084 23.6233 42.4051 22.6135C42.5995 22.4362 42.8059 22.2724 43.0123 22.107C43.0823 22.0507 43.1607 21.9893 43.2443 21.9722C43.321 21.9569 43.4097 21.9961 43.4933 22.0132C43.4643 22.0883 43.4489 22.1735 43.4029 22.2349C42.8554 22.9496 42.081 23.4135 41.4261 24.0088C40.5255 24.8274 39.7017 25.7297 38.8011 26.5501C38.0984 27.1914 37.3462 27.7832 36.5855 28.3564C35.4462 29.2126 34.3768 30.1302 33.6024 31.348C33.5513 31.4281 33.4882 31.5015 33.4165 31.597V31.5953Z" fill="#D8501C" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_151_2323">
                                        <rect width="46" height="46.8519" fill="white" transform="translate(0 2)" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Step 3">
                        <a id="step_3_btn" disabled class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step3" id="step3-tab" data-bs-toggle="tab" role="tab" aria-controls="step3" aria-selected="false" title="Step 3">
                            <svg width="46" height="50" viewBox="0 0 46 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_151_2324)">
                                    <path d="M18.0257 20.8379C17.9593 20.7657 17.9294 20.7168 17.8881 20.6912C15.5054 19.2421 13.9918 17.1197 13.1938 14.4428C13.1639 14.3403 13.1204 14.2424 13.0997 14.1376C13.0676 13.9675 12.969 13.8976 12.8062 13.8767C11.9944 13.7765 11.4531 13.3198 11.2055 12.5394C10.9578 11.7636 11.2055 11.1042 11.7673 10.5615C12.1297 10.2096 12.5883 10.0955 13.086 10.0978C15.3494 10.1025 17.6152 10.0978 19.8787 10.0978C20.5185 10.0978 21.1584 10.0978 21.7981 10.0931C21.9083 10.0931 22.0184 10.0722 22.1422 10.0605C22.1422 9.69242 22.1468 9.3546 22.1422 9.01679C22.117 7.63292 23.2728 6.39349 24.2383 6.09296C24.651 5.96481 25.096 5.88094 25.5271 5.87629C28.0589 5.85765 30.5906 5.86696 33.1225 5.87163C33.971 5.87163 34.6681 5.39169 34.9457 4.55764C34.7622 4.54366 34.5879 4.52968 34.4113 4.51571C33.3197 4.41553 32.4184 3.55119 32.3405 2.52842C32.2487 1.32162 32.9092 0.382724 34.0582 0.084516C34.1866 0.0518994 34.3196 0.019283 34.4526 0.0169532C35.3791 0.0122937 36.3079 -0.0226526 37.2298 0.0239424C38.1769 0.0728672 39.007 0.837027 39.2341 1.75961C39.5368 3.00136 38.5644 4.38991 37.3123 4.49939C37.0073 4.52503 36.7023 4.51571 36.3973 4.54133C36.3239 4.54833 36.2092 4.61123 36.1909 4.67414C35.6267 6.47969 34.3356 7.0994 32.8862 7.0994C30.4783 7.0994 28.068 7.17163 25.6647 7.07844C24.0937 7.01786 23.1764 8.13847 23.3461 9.65981C23.3943 10.0861 23.3852 10.0885 23.8209 10.0885C26.7058 10.0908 29.5908 10.0978 32.4758 10.0931C33.127 10.0931 33.65 10.3308 34.0375 10.8549C34.8677 11.9756 34.2989 13.5528 32.9504 13.851C32.7394 13.8976 32.6661 13.9931 32.6248 14.1796C32.2052 15.9665 31.3406 17.5111 30.1251 18.8553C29.4899 19.5589 28.7698 20.1646 27.9419 20.6283C27.8914 20.6563 27.841 20.6819 27.7928 20.7145C27.7722 20.7284 27.7584 20.7587 27.7057 20.8333C27.9052 20.8449 28.068 20.8612 28.2309 20.8612C30.6961 20.8612 33.1614 20.8612 35.6267 20.8519C36.2046 20.8519 36.7436 20.9522 37.232 21.2853C38.7846 22.3499 38.7296 24.5609 37.1059 25.5115C36.8009 25.6886 36.7275 25.8702 36.7298 26.2057C36.7436 31.3312 36.7412 36.4543 36.7412 41.5798C36.7412 41.871 36.7344 42.1622 36.7596 42.4534C36.7665 42.5303 36.8674 42.6281 36.9477 42.6631C37.0761 42.7167 37.232 42.7097 37.3628 42.7609C37.4499 42.7959 37.5463 42.8727 37.5829 42.9567C38.3672 44.8274 39.1286 46.7099 39.9312 48.5737C40.1285 49.035 39.8923 49.4986 39.3396 49.5149C38.9382 49.5265 38.5369 49.5429 38.1356 49.5429C27.9327 49.5429 17.7276 49.5429 7.52473 49.5429C7.27706 49.5429 7.02709 49.5429 6.77942 49.5265C6.04557 49.4822 5.83917 49.1561 6.12124 48.4735C6.58908 47.3389 7.0592 46.2043 7.53162 45.0721C7.78388 44.4664 8.0499 43.8652 8.29987 43.2572C8.50627 42.7563 8.63469 42.6421 9.1805 42.6724C9.43734 42.6864 9.48092 42.6025 9.48092 42.3695C9.48092 37.0111 9.48321 31.655 9.48551 26.2966C9.48551 26.1801 9.50155 26.059 9.47174 25.9495C9.44881 25.8632 9.3869 25.7491 9.3135 25.7188C8.21273 25.2739 7.54996 24.2674 7.63711 23.149C7.72196 22.082 8.55443 21.1595 9.67585 20.9242C9.96251 20.8636 10.2629 20.8589 10.5588 20.8589C13.0034 20.8589 15.4504 20.8636 17.895 20.8659C17.9225 20.8659 17.9478 20.8542 18.0303 20.8379H18.0257ZM31.5722 34.4437V25.8679H14.6156V34.4437C15.3311 34.4437 16.026 34.4298 16.7209 34.4507C17.0029 34.4601 17.0694 34.3668 17.0671 34.0919C17.058 32.6848 17.0671 31.2776 17.0718 29.8705C17.074 29.288 17.2712 29.0922 17.8514 29.0806C17.918 29.0806 17.9844 29.0806 18.051 29.0806C20.897 29.0806 23.7429 29.0806 26.5888 29.0783C27.1324 29.0783 27.6782 29.0736 28.2217 29.0853C28.6505 29.0946 28.8753 29.309 28.8982 29.7423C28.9211 30.2059 28.9235 30.6742 28.9257 31.1378C28.9326 32.1466 28.9326 33.1553 28.9349 34.1642C28.9349 34.2993 28.9074 34.4461 29.1207 34.4437C29.9302 34.4414 30.742 34.4437 31.5676 34.4437H31.5722ZM18.2986 34.4251H27.6736V30.3014H18.2986V34.4251ZM22.7866 12.6699C25.644 12.6699 28.5015 12.6699 31.3566 12.6699C31.7579 12.6699 32.1593 12.6745 32.5606 12.6652C32.9367 12.6559 33.2417 12.3903 33.2669 12.0711C33.2899 11.7845 33.0239 11.4304 32.6936 11.3629C32.4711 11.3163 32.2395 11.3116 32.0102 11.3116C25.7519 11.3116 19.4934 11.3116 13.235 11.3116C13.1295 11.3116 13.0241 11.3116 12.9209 11.3256C12.5677 11.3791 12.3315 11.6447 12.3384 11.9709C12.3452 12.3367 12.5906 12.6209 12.953 12.6535C13.1915 12.6745 13.43 12.6699 13.6685 12.6699C16.7071 12.6699 19.7457 12.6699 22.7843 12.6699H22.7866ZM12.4094 46.7309C12.4094 46.7309 12.4094 46.7262 12.4094 46.7239C13.5836 46.7239 14.7578 46.7239 15.9297 46.7239C16.1475 46.7239 16.37 46.7192 16.5856 46.6889C16.8859 46.6493 17.074 46.4093 17.0763 46.1088C17.0763 45.8223 16.8952 45.5869 16.6062 45.5334C16.4388 45.5031 16.2645 45.5031 16.0925 45.5007C14.4986 45.5007 12.9048 45.5007 11.311 45.5007C10.49 45.5007 9.66897 45.5054 8.84797 45.4937C8.64157 45.4914 8.54066 45.5567 8.48562 45.7617C8.426 45.9853 8.32739 46.1974 8.23795 46.4093C8.11182 46.7145 8.11871 46.7285 8.45352 46.7285C9.76987 46.7285 11.0862 46.7285 12.4049 46.7285L12.4094 46.7309ZM35.801 1.28667C35.363 1.28667 34.9227 1.27269 34.4847 1.29133C33.9251 1.31462 33.4894 1.79456 33.5032 2.33506C33.5169 2.85692 33.9458 3.28559 34.4984 3.29259C35.347 3.30657 36.1955 3.30657 37.044 3.29724C37.6013 3.29026 38.0622 2.81732 38.0622 2.2838C38.0622 1.75728 37.6173 1.30764 37.0601 1.29133C36.6404 1.27968 36.2207 1.289 35.801 1.289V1.28667ZM21.9473 45.5241C21.9473 45.5241 21.9473 45.5171 21.9473 45.5147C21.5574 45.5147 21.1653 45.4961 20.7753 45.5194C20.3947 45.545 20.1654 45.799 20.1745 46.1251C20.1814 46.4303 20.4222 46.6959 20.7731 46.7029C21.562 46.7192 22.3531 46.7029 23.142 46.6889C23.2475 46.6889 23.369 46.6354 23.4516 46.5678C23.6443 46.4117 23.7406 46.195 23.6649 45.9481C23.5938 45.7127 23.4287 45.5357 23.1742 45.5264C22.766 45.5101 22.3555 45.5217 21.9473 45.5217V45.5241Z" fill="#D8501C" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_151_2324">
                                        <rect width="34" height="49.5429" fill="white" transform="translate(6)" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Step 4">
                        <a id="step_4_btn" disabled class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step4" id="step4-tab" data-bs-toggle="tab" role="tab" aria-controls="step4" aria-selected="false" title="Step 4">
                            <svg width="46" height="50" viewBox="0 0 46 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_151_2322)">
                                    <path d="M34.3125 15.6875V12.75C34.3125 6.27098 29.0414 1 22.5625 1C16.0835 1 10.8125 6.27098 10.8125 12.75V15.6875H2V40.6562C2 44.7121 5.28789 48 9.34375 48H35.7812C39.8372 48 43.125 44.7121 43.125 40.6562V15.6875H34.3125ZM16.6875 12.75C16.6875 9.51049 19.323 6.875 22.5625 6.875C25.802 6.875 28.4375 9.51049 28.4375 12.75V15.6875H16.6875V12.75ZM31.375 23.7656C30.1582 23.7656 29.1719 22.7793 29.1719 21.5625C29.1719 20.3457 30.1582 19.3594 31.375 19.3594C32.5918 19.3594 33.5781 20.3457 33.5781 21.5625C33.5781 22.7793 32.5918 23.7656 31.375 23.7656ZM13.75 23.7656C12.5332 23.7656 11.5469 22.7793 11.5469 21.5625C11.5469 20.3457 12.5332 19.3594 13.75 19.3594C14.9668 19.3594 15.9531 20.3457 15.9531 21.5625C15.9531 22.7793 14.9668 23.7656 13.75 23.7656Z" fill="#D8501C" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_151_2322">
                                        <rect width="41.6286" height="47" fill="white" transform="translate(2 1)" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">
                        <h4 class="text-center">What kind of coffee bean are you looking for?</h4>
                        <div class="d-flex mb-5 py-lg-5 cards-row justify-content-center">
                            <button class="option-button" onclick="setPressedOption('roast','yes',this)">
                                <div id="roasted" class="card selectable-card border-0 py-2 px-4">
                                    <div class="card-body">
                                        <div class="card-content">
                                            {{-- <h5 class="card-title">Option 1</h5> --}}
                                            <img id="img_roast_yes" src="{{ asset('images/buyer/roasted.svg') }}" alt="yes image" class="h-60 w-full">
                                            <p id="roast_yes_txt" class="card-text text-center mt-3">Roasted</p>
                                            <!-- Additional content -->
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button class="option-button" onclick="setPressedOption('roast','no',this)">
                                <div id="not_roasted" class="card selectable-card border-0 py-2 px-4">
                                    <div class="card-body">
                                        <div class="card-content">
                                            {{-- <h5 class="card-title">Option 1</h5> --}}
                                            <img src="{{ asset('images/buyer/not_roasted.svg') }}" alt="yes image" class="h-60 w-full">
                                            <p id="roast_no_txt" class="card-text text-center mt-3">Green</p>
                                            <!-- Additional content -->
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a id="roast_yes_option_btn" style="display:none" class="btn btn-primary next">Continue</a>
                            <a id="roast_no_option_btn" style="display:none" href="{{route('buyer_market_place')}}" class="btn btn-primary">Continue</a>
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" id="step2" aria-labelledby="step2-tab">
                        @include('new_web_pages.buyer_pages.buyer_product_selection')
                        <div class="d-flex justify-content-between mt-3 mt-lg-5">
                            <a class="btn btn-secondary previous"> Previous</a>
                            <a class="btn btn-primary next" id="btn_prod_selection_next" style="display: none;">Next</a>
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" id="step3" aria-labelledby="step3-tab">
                        @include('new_web_pages.buyer_pages.buyer_roast_grind_section')
                        <div class="d-flex justify-content-between mt-3 mt-lg-5">
                            <a class="btn btn-secondary previous"> Previous</a>
                            <a class="btn btn-primary next" id="btn_roast_grind_next" style="display: none;">Next</a>
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
                        @include('new_web_pages.buyer_pages.3d_preview.new_bag_preview')
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@include('new_web_pages.buyer_pages.order_placed_modal')
@include('new_web_pages.buyer_pages.roast_modals')
@include('new_web_pages.buyer_pages.grindtype_modals')
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<!-- Scripts -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/libs/fflate.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- <script src="{{ asset('js/threejsmodel.js') }}"></script> -->
<script src="{{ asset('js/product_preview.js') }}"></script>
<!-- <script src="{{ asset('js/img_preview.js') }}"></script> -->
<script src="{{ asset('js/roast_grind_selection.js') }}"></script>
<script src="{{ asset('js/wizard_prod_details.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        //Enable Tooltips
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Function to initialize Select2
        function initializeSelect2() {
            $('.form-select').select2();
        }

        //Advance Tabs
        $(".next").click(function() {
            const nextTabLinkEl = $(".nav-tabs .active")
                .closest("li")
                .next("li")
                .find("a")[0];
            const nextTab = new bootstrap.Tab(nextTabLinkEl);
            nextTab.show();

            // Initialize Select2 if the next tab is step 2
            if ($('#step2').hasClass('active')) {
                initializeSelect2();
            }
        });

        $(".previous").click(function() {
            const prevTabLinkEl = $(".nav-tabs .active")
                .closest("li")
                .prev("li")
                .find("a")[0];
            const prevTab = new bootstrap.Tab(prevTabLinkEl);
            prevTab.show();

            // Initialize Select2 if the previous tab is step 2
            if ($('#step2').hasClass('active')) {
                initializeSelect2();
            }
        });

        // Initialize Select2 on document ready if step 2 is active
        if ($('#step2').hasClass('active')) {
            initializeSelect2();
        }
    });
</script>

<script type="text/javascript">
    var roasttypeselected = "no";
    var grindtypeseleted = "no";

    function setPressedOption(option, content, clickedOption) {

        // trigger this when its not bag size 
        if (option != "bag_size") {
            activateCardOptions(option, content, clickedOption);
        }

        // $('#response').html("<b>Loading response...</b>");
        $.ajax({
                type: 'GET',
                url: '/buyerOrderOptions/' + option + '/' + content
            })
            .done(function(data) {
                // show the response
                // alert(data);
            })
            .fail(function() {
                // just in case posting your form failed
                alert("Posting failed.");
            });
        // to prevent refreshing the whole page page
        return false;
    }

    function activateCardOptions(option, content, clickedOption) {

        var roasted_option = document.getElementById("roasted");
        var not_roasted_option = document.getElementById("not_roasted");
        var img_yes_roast = document.getElementById("img_roast_yes");
        var txt_yes_roast = document.getElementById("roast_yes_txt");
        var txt_no_roast = document.getElementById("roast_no_txt");


        var step_2_btn = document.getElementById("step_2_btn");
        // var step_3_btn = document.getElementById("step_3_btn");
        var step_4_btn = document.getElementById("step_4_btn");
        // console.log(clickedOption);
        // const cOption =  document.getElementsByName(clickedOption);

        if (option == "roast") {
            triggerRoastBtn(option, content);
            step_2_btn.removeAttribute('disabled');
            if (content == "yes") {
                //    img_yes_roast.setAttribute("src", "{{ asset('images/buyer/roasted_white.svg') }}");
                roasted_option.classList.add("activate_option");
                not_roasted_option.classList.remove("activate_option");

                //    txt_yes_roast.classList.add("text-white");
                //    txt_no_roast.classList.remove("text-white");

            } else {
                //    img_yes_roast.setAttribute("src", "{{ asset('images/buyer/roasted.svg') }}");
                not_roasted_option.classList.add("activate_option");
                roasted_option.classList.remove("activate_option");

                //    txt_no_roast.classList.add("text-white");
                //    txt_yes_roast.classList.remove("text-white");
            }
        }

        if (option == "roast_type") {
            // step_3_btn.removeAttribute('disabled');
            // alert('I got here ' + content);
            var elems = document.querySelectorAll("#roast_type");
            [].forEach.call(elems, function(el) {
                el.classList.remove("selected");
            });

            var clickedelems = document.querySelectorAll("." + clickedOption);
            [].forEach.call(clickedelems, function(clickel) {
                clickel.classList.add("selected");
            });
            roasttypeselected = 'yes';
            showRoastNextBtn();
            // cOption.classList.add("activate_option");
        }

        if (option == "grind_type") {

            step_4_btn.removeAttribute('disabled');
            var elems = document.querySelectorAll("#grind_type");
            [].forEach.call(elems, function(el) {
                el.classList.remove("selected");
            });
            var clickedelems = document.querySelectorAll("." + clickedOption);
            [].forEach.call(clickedelems, function(clickel) {
                clickel.classList.add("selected");
            });
            grindtypeseleted = 'yes';
            showRoastNextBtn();
            // clickedOption.classList.add("activate_option");
        }

        if (option == "bag_size") {
            triggerBagBtn(option, content);
            showModel(content);
            step_4_btn.removeAttribute('disabled');
            var elems = document.querySelectorAll("#bag_size");
            [].forEach.call(elems, function(el) {
                el.classList.remove("activate_option");
            });
            var clickedelems = document.querySelectorAll("." + clickedOption);
            [].forEach.call(clickedelems, function(clickel) {
                clickel.classList.add("activate_option");
            });
            // clickedOption.classList.add("activate_option");
        }

    }

    function triggerRoastBtn(option, content) {
        var roast_yes_option_btn = document.getElementById("roast_yes_option_btn");
        var roast_no_option_btn = document.getElementById("roast_no_option_btn");

        if (content == "no") {
            roast_yes_option_btn.style.display = "none";
            roast_no_option_btn.style.display = "block";
        } else {
            roast_yes_option_btn.style.display = "block";
            roast_no_option_btn.style.display = "none";
        }
    }

    function triggerBagBtn(option, content) {
        var bag_option_btn = document.getElementById("bag_option_btn");

        // bag_option_btn.style.display = "none";
        bag_option_btn.style.display = "block";
    }

    function showRoastNextBtn() {
        // alert(grindtypeseleted + " and " + roasttypeselected);
        if (grindtypeseleted == "yes" && roasttypeselected == "yes") {
            var roast_btn = document.getElementById("btn_roast_grind_next");
            roast_btn.style.display = "block";

            // Initialize preview images for default selection (12oz)
            setupPreviewImages('12oz');
            saveBagOption('12oz');
        }
    }
</script>

@endsection