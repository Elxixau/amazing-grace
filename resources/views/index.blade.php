<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{config('app.name') }}</title>
    <link href="{{ asset('images/LOGO. REV2.png') }}" rel="shortcut icon" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @include('includes.link')
</head>
<body style="background-color: #331D54;">
    


    @if($post)
    <div class=" custom-jumbotron">
        <div class="banner text-center">
            <div class="container">
            @include('includes.notification')
                <h2>Hurry Up! Dont Miss Your Chance</h2>
                <img src="{{asset('images/spanda.png')}}" alt="">
                <h3 class="section-title">"{{$post->title}}"</h3>
                <h1 class="fs-2 fw-lighter mt-2 w-70 text-uppercase">{{$post->subtitle}}</h1>
                <h2 >| {{ optional($post->start_date)->translatedFormat('d F Y') }} - {{ optional($post->end_date)->translatedFormat('d F Y') }} | 24 HOUR BOOK | </h2>                    
            </div>
        </div>
        <a href="#book" class="scroll-down-btn text-center"><i class="fas fa-arrow-down"></i></a>
        
    </div>
    
    <section id="content">
        <div class="head">
            <div class="  container aos-init aos-animate" data-aos="fade-up">
                <div class="col-lg-15">
                    <h4 class="section-title mt-5"> Description</h4>
                    <h1 class="fs-2 fw-lighter  mt-2 w-70 text-uppercase">{{$post->subtitle}}</h1>
                    <p class="mt-2 fs-6 opacity-50 w-70">{{$post->content}}</p>
                </div>

                <div class="col-lg-15">
                    <h4 class="section-title mt-5 mb-2">Guest Star</h4>
                    <div class="lightbox text-center">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="images">
                                    <img
                                    src="{{asset('images/GS.svg')}}"
                                    data-mdb-img="{{asset('images/GS.svg')}}"
                                    alt="Table Full of Spices"
                                    class="w-100 mb-3 mb-md-4 shadow-1-strong rounded"
                                    />
                                    <h4 class="card-text ">Jeshua Abraham</h4>
                                    <p><i>Singer</i></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="images">
                                    <img
                                        src="{{asset('images/Ps. Christofer Tapiheru (1).svg')}}"
                                        data-mdb-img="{{asset('images/Ps. Christofer Tapiheru.svg')}}"
                                        alt="Dark Roast Iced Coffee"
                                        class="w-100 mb-3 shadow-1-strong mb-md-4 rounded"
                                    />
                                    <h4 class="card-text">Ps. Christofer Tapiheru</h4>
                                    <p><i>Speaker</i></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="images">
                                    <img
                                        src="{{asset('images/MC.svg')}}"
                                        data-mdb-img="{{asset('images/MC.svg')}}"
                                        alt="Dark Roast Iced Coffee"
                                        class="w-100 mb-3 shadow-1-strong mb-md-4 rounded"
                                    />
                                    <h4 class="card-text">Raymond Peranginangin</h4>
                                    <p><i>Master of Ceremony</i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" service col-lg-15">
                    <h4 class="section-title mt-5 mb-3">Layanan Panitia</h4>
                    <p> Productive Day : <span>{{$post->weekday_service_hours}} </span></p>
                    <p> Weekend Day : <span>{{$post->weekend_service_hours}}</span></p>
                </div>

                <div class="col-lg-15">
                    <h4 class="section-title mt-5 mb-3"> Bagaimana Cara Menghubungi Panitia ketika saya menghadapi Kesulitan? </h4>
                    <p>Click <a href=""><u>hubungi admin</u></a> untuk mempermudah anda ketika mengadapi kesulitan dalam melakukan booking tiket</p>
                </div>

                <div class="col-lg-15">
                    <h4 class="section-title mt-5 mb-3"> Event by</h4>
                    <div class="row gy-5">
                    <div class="col-6 col-md-3 align-self-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="125" height="65" viewBox="0 0 125 65" fill="currentColor" class="text-dark">
                        <path d="M31.75,14.84c15.02,2.84,29.72,.88,35.7,.55-10.07,9.01-10.28,27.63-22.14,27.72-1.82,.01-3.91-.41-6.35-1.36,8.43-19.24-4.19-24.25-7.21-26.9h0Zm-4.65,1.64c5.54-.19,12.32,6.08,12.62,12.62,.43,9.34-4.89,13.45-4.84,16.65,.05,3.01,2.54,5.76,3.5,7.72h-7.71c-.43-1.49-1.53-2.14-1.56-2.25-.46-1.57,.56-2.81,.53-5.22-.1-6.93-10.64-7.36-10.93-20.45-.1-4.72,2.78-8.88,8.39-9.08h0Zm44.76,14.38c-3.05,.07-4.92,3.29-8.04,6.73-1.68,2.72-3.07,11.4-3.52,15.88h8.19c.43-3.59-1.94-2.8-1.79-4.25,.51-5,3.48-4.41,4.02-9.03,3.63-.33,5.44-2.48,5.54-4.75,.14-3.32-2.78-4.61-4.38-4.57h0Zm3.45,9.86c-.46,.22-1.32,1.18-3.14,1.19-1.13,3.17-3.01,3.26-3.93,6.41-.31,.51,1.47,1.39,.98,2.36,.24,.33,1.27,1,1.34,2.79h6.06c-.9-4.36-4.19-4.23-4.21-5.69-.05-3.14,2.36-5.35,2.89-7.06h0Zm-37.43,1.07c.22,1.43-1.69,1.83-1.59,5.04,.04,1.16,2.41,4.65,3.89,6.64h5.31c-2.53-4.38-6.12-5.5-6.14-6.78-.03-1.34,1.25-3.26-1.46-4.89h0Zm-19.79-12.41c.88,1,1.63,3.54,1.49,6.05-.13,2.51-1.46,3.35-2.02,4.34-1.08-1.42-1.59-2.98-1.59-5.15s1.46-4.35,2.12-5.24h0Zm57.96-14.97c3.82-.37,5.48,2.34,5.62,4.89,.26,4.8-3.21,4.87-3.29,8.63-.04,2.22,.69,1.34,.87,6.41,.13,3.64-2.31,5.17-3.38,5.86-.03-.46,1.4-3.12,1.13-6.47-.24-2.93-3.06-4.19-5.01-4.2-5.21-.02-8.73,9.68-15.36,12.5-.78,.33-3.01,.25-3.32-.17,8.84-7.17,7.76-26,22.74-27.45h0Zm11.6-.91c.04,1.01,.16,2.7-1.09,4.12s-2.98,1.5-3.8,1.66c.02-1.36,.51-2.47,1.53-3.75s2.57-1.82,3.37-2.03h0Zm-.22,10.65c.99,4.6,9.12,9.62,8.84,11.54-.3,2.12,.84,5.85-1.94,6.36-.26-1.32-.78-1.89-1.53-1.87-1.03,.03-1.34,2.5-1.18,4.01-1.9,.42-3.84-1.59-5.69-2.91-2.04-1.47-4.11-2.88-5.73-4.72,.98-3.81-.89-10.1,.19-11.33,.91-1.03,4.46,.44,7.03-1.09h0Zm12.25-.37c2.03,4.23-1.66,8.76-4.59,8.48-.83-.08-1.89-1.51-1.58-2.49,2.86-1.81,5.18-4.67,6.16-5.99h0Zm-9.28-8.46c.78,3.89-1.88,8.98-8.23,8.54,.71-1.02,.16-2.73,.68-3.71,2.79-.31,6.26-3.21,7.55-4.83Zm18.78,6.77c2.22,5.42-7.65,15.37-10.59,15.84-1.75,.28-1.52-3.14-1.38-4.31,2.86-1.81,10.26-7.29,11.98-11.52h0Zm-20.12,9.95c.07,1.6-.84,2.38-1.75,2.22-.95-.17-1.4-1.66-1.23-2.75,.92,.72,2.28,.74,2.98,.53h0ZM8.63,59.58H106.17c1.31,0,2.61-.56,3.64-1.46h0c1.06-.93,1.83-2.16,2.06-3.5l7.73-45.17c.04-.25,.06-.51,.06-.77,0-.84-.26-1.58-.71-2.14-.45-.55-1.1-.94-1.88-1.07-.24-.04-.48-.06-.71-.06H18.82c-1.31,0-2.61,.56-3.64,1.46-1.06,.91-1.83,2.15-2.06,3.49L5.39,55.54c-.04,.25-.06,.51-.06,.77,0,.84,.26,1.58,.72,2.14,.45,.55,1.1,.94,1.88,1.07,.21,.04,.45,.06,.71,.06h0Zm0,5.42c-.54,0-1.08-.05-1.61-.14-2.09-.37-3.85-1.42-5.08-2.93-1.23-1.51-1.94-3.45-1.94-5.61,0-.54,.05-1.1,.15-1.68L7.87,9.46c.45-2.62,1.89-4.99,3.85-6.68,1.98-1.71,4.51-2.77,7.1-2.77H116.37c.54,0,1.08,.05,1.61,.14,2.09,.37,3.84,1.42,5.08,2.93,1.23,1.51,1.94,3.45,1.94,5.61,0,.54-.05,1.1-.15,1.68l-7.73,45.17c-.45,2.63-1.89,5-3.85,6.7h0c-1.98,1.69-4.5,2.76-7.1,2.76H8.63Z" fill-rule="evenodd" />
                        </svg>
                    </div>
      
    </div>
                </div>
            </div>
        </div>
        <div class="event">
            <div class="container">
                <div class="col-lg-15 ">
                    <h4 class="section-title mb-2">Event Location</h4>
                    <div class="embed-responsive embed-responsive-16by9 mt-4 mb-4">
                        <iframe  src="{{$post->map_embed_url}}"></iframe>
                    </div>
                    <h4 class="section-title ">{{$post->location_name}}</h4>
                    <p>{{$post->location_details}}</p>
                    <hr  style="height:1px;border-width:0;color:gray;background-color:gray">
                </div>
                <div class="col-lg-15">
                    <h4 class="section-title mt-5 mb-3">Tags</h4>
                    @foreach($post->tags as $tag)
                        <button type="button" class="btn btn-light mr-2 mb-2">{{ $tag->name }}</button>
                    @endforeach
                </div>

                <div class="col-lg-15 ">
                    <h4 class="section-title mt-5 mb-3">Bagikan</h4>
                    <a href=""><i class="fab fa-twitter"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-whatsapp"></i></a>
                    <hr  style="height:1px;border-width:0;color:gray;background-color:gray">
                </div>
                <div id="book" class="col-lg-15 ">
                    <h4 class="section-title mt-5 mb-3">Tiket</h4>
                    <div class="book ">
                        <div class="container">
                            <center>
                                <div class="card mb-5 text-center shadow-md" style="background-color: #331D54;">
                                    <div class="card-body" >
                                        <p class="card-text mt-3">Amazing Grace <br>Concert and Revival Service</p>
                                        <a href="{{route('create')}}" class="btn btn-light">Booking</a>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div> 
                     
                </div>
            </div>
        </div>
    </section>
   
@else
    <div class="d-flex justify-content-center   align-items-center vh-100">
        <p class="text-white">Sepertinya sedang terjadi kesalahan....</p>
    </div>
@endif

    

    

    @include('includes.script')
    <script>
        // The audio element
        var audio = document.getElementById('background-music');

        // Check if the browser supports autoplay
        var isAutoplaySupported = false;
        document.addEventListener('DOMContentLoaded', function () {
            isAutoplaySupported = audio.autoplay;

            // If autoplay is not supported, play on user interaction (e.g., click)
            if (!isAutoplaySupported) {
                document.body.addEventListener('click', function () {
                    audio.play();
                });
            }
        });

        // Fallback for browsers that don't support autoplay
        audio.addEventListener('loadedmetadata', function () {
            if (!isAutoplaySupported) {
                audio.play();
            }
        });
    </script>
</body>
</html>