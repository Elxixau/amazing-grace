<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> {{config('app.name') }}</title>
   
    <!-- FAVICON -->
    <link href="{{ asset('images/LOGO. REV2.png') }}" rel="shortcut icon" />
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
    @include('includes.link')
</head>
<body style="background-color: #331D54;">
    <div class="container scoped-container mt-4 mb-5 ">

        
        @include('includes.notification')
 
        <div class="dies d-flex flex-wrap justify-content-between align-items-center w-full">
            <div class="text  d-flex align-items-center">
                <img src="{{asset('images/LOGO. REV2.png')}}" class="mr-3"/>
                <div class="text">
                    <h1>Amazing Grace</h1> 
                    <h3>Concert and Revival Service</h3>
                </div>            
            </div>
            <p>"Around the World"</p>
        </div>
        <div class="row mt-4">

                {{-- Kolom Form Tiket --}}
                <div class="form col-lg-8 order-2 order-lg-1 mb-4">
                    
                    <div class="card form-tiket">
                        <div class=" p-4 fw-bolder   ">Pesan Tiket</div>

                        
                        <div class="card-body">
    
                            <!-- Form Booking Tiket -->
                                <form id="bookingForm" action="{{ route('tiket.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Nama Lengkap:</label>
                                        <input type="text" class="form-control border-bottom" id="name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control border-bottom" id="email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Jumlah Kursi:</label>
                                        <div class="seat-radio-buttons">
                                            @foreach($seatOptions as $seatOption)
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input seat-radio" id="seat_{{ $seatOption }}" name="seat_count" value="{{ $seatOption }}">
                                                    <label class="form-check-label seat-label" for="seat_{{ $seatOption }}">{{ $seatOption }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Pilih Group Kursi:</label>
                                        <div class="seat-radio-buttons text-center">
                                            <div class="row">
                                                @foreach($seatGroup as $group)
                                                    <div class="col-md-6 col-lg-6  d-flex align-items-stretch">
                                                        <label class="card group-card text-center w-100" for="seat_{{ $group->group_code }}">
                                                            <div class="p-2">Group</div>
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $group->group_name }}</h5>
                                                                <p class="card-text" >Sisa Kuota: <p style="font-weight:700; background-color: #f0ff46; padding: 5px 10px 5px 10px ; border-radius:12px">{{ $group->quota }}</p></p>
                                                                <input type="radio"
                                                                    id="seat_{{ $group->group_code }}"
                                                                    name="seat_group"
                                                                    value="{{ $group->group_code }}">
                                                                    
                                                            </div>
                                                            
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <span class="text-white ">
                                            Cek preview pesanan anda sebelum melakukan booking
                                        </span>
                                    </center>
                                </form>

                        </div>
                    </div>
                    <div class="donation">
                    <div class="card text-center mt-5">
                        <div class="card-header">
                            Donation
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Open Donation For Support Us: </h5>
                            <p class="card-text">"Acara ini gratis tidak dipungut biaya untuk tiket masuk, namun buat saudara/i yang berkerinduan untuk membantu menyukseskan acara ini dapat melakukan donasi"</p>
                            <h5 class="card-title"> (BRI 724401014706532 a.n DIES NATALIS KBMK POLNES)</h5>
                        </div>
                        <div class="card-footer text-muted">
                            GOD BLESS ALL!!!
                        </div>
                    </div>
                </div>
                </div>
                
                {{-- 👉 Card Informasi Event --}}
                <div class="col-lg-4 order-1 order-lg-2 mb-4">
                    <div class=" sticky-top " style="top: 80px; ">
                        <div class="card shadow">
                            
                            @if($post->banner_image)
                                <img src="{{ asset('storage/' . $post->banner_image) }}" class="card-img-top" alt="{{ $post->title }}">
                            @endif

                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                
                                </div>

                                <hr>
                                <div class="d-flex align-items-center justify-content-between text-muted">
                                    @if($post->start_date)
                                        <div class="fs-5 link-secondary text-decoration-none d-flex align-items-center " href="#!">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mr-2 bi bi-calendar3" viewBox="0 0 16 16">
                                                <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
                                                <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                            </svg>
                                            <span class="ms-2 fs-5">{{ optional($post->start_date)->translatedFormat('d F Y') }}</span>
                                        </div>
                                    @endif

                                    @if($post->price)
                                        <div class="fs-5 link-secondary text-decoration-none d-flex align-items-center " href="#!">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mr-2 bi bi-ticket-detailed" viewBox="0 0 16 16">
                                                <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2z"/>
                                                <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5z"/>
                                            </svg>
                                            <span class="ms-2 fs-5">{{$post->price}}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($post->location_details)
                                    <div class="location d-flex align-items-start mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/>
                                        </svg>
                                        <h6>Venue</h6>
                                    </div>
                                    <p class="card-textfs-2 mb-1 fs-lg"> {{ $post->location_details }}</p>
                                @endif
                                    
                        </div>
                        </div>
                            {{-- ✅ Card Preview (tidak sticky, ikut scroll biasa di bawah event) --}}
                            <div class="card shadow mt-4">
                                <div class="card-body">
                                    <p class="text-warning ">Preview Pemesanan Anda</p>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <th class="text-muted">Nama</th>
                                            <td id="previewName">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td id="previewEmail">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Jumlah Kursi</th>
                                            <td id="previewSeat">-</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Group Kursi</th>
                                            <td id="previewGroup">-</td>
                                        </tr>
                                    </table>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-warning btn-md w-100" id="submitBtn" form="bookingForm">
                                            <span id="submitText">🎟 Booking Tiket</span>
                                            <div id="submitSpinner" class="spinner-border spinner-border-sm text-light ms-2 d-none" role="status"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                   
                        </div>
                    </div>
                   <!-- Live Preview + Tombol Submit -->
                   
    

                </div>

            </div>
    </div>
@include('includes.script')
<script src="{{ asset('js/booking.js') }}"></script>


</body>
</html>