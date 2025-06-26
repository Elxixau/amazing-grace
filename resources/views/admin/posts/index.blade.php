@extends('layouts.admin')

@section('title', 'Page Setting')

@php
  $breadcrumbItems = [
    ['label' => 'Costumization', 'url' => route('admin.post.index')],
  ];
@endphp

@section('content')
  <div class="card shadow card-default p-4">
            <h3 class="mb-4">Daftar Post</h3>

              @include('includes.notification')

              <a href="{{ route('admin.post.create') }}" class="btn btn-primary mb-3">+ Tambah Event</a>
              <div class=" overflow-hidden ">
                <div class="row gy-4 gy-md-5 gx-xl-6 gy-xl-6 gx-xxl-9 gy-xxl-9">
                   @foreach($posts as $post)
                  <div class="col-12 col-lg-4 ">
                        <article class="shadow-sm">
                          <div class="card border-1 shadow-sm p-4 bg-transparent">
                            <div class="card-header border-0 bg-transparent p-0 mb-2">
                              <ul class="entry-meta list-unstyled d-flex align-items-center justify-content-between w-100 ">
                                <li class="mr-2">
                                  <form action="{{ route('admin.post.toggle-show', $post->slug) }}" method="POST" class="d-inline">
                                          @csrf
                                          @method('PATCH')
                                          <button class="btn btn-sm {{ $post->show ? 'btn-success' : 'btn-outline-secondary' }}">
                                              {{ $post->show ? 'Sedang Digunakan ✔' : 'Gunakan' }}
                                          </button>
                                      </form>
                                </li>
                                  <li>
                                    <form id="deleteForm{{ $post->slug }}" action="{{ route('admin.post.destroy', $post->slug) }}" method="POST" id="deleteForm{{ $post->id }}">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button"  onclick="confirmDelete({{ $post->slug }})"  >
                                        <i class="mdi mdi-close text-danger "  style="font-size: 25px;" ></i>
                                      </button>
                                    </form>
                                  </li>
                              </ul>
                            </div>
                            <figure class="card-img-top mb-4 overflow-hidden bsb-overlay-hover">
                              <a href="{{ route('admin.post.edit', $post->slug) }}">
                                <img class="img-fluid bsb-scale bsb-hover-scale-up" loading="lazy" src="{{ asset('storage/' . $post->banner_image) }}" alt="Living">
                              </a>
                              <figcaption>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-eye text-white bsb-hover-fadeInLeft" viewBox="0 0 16 16">
                                  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                </svg>
                                <h4 class="h6 text-white bsb-hover-fadeInRight mt-2">Details</h4>
                              </figcaption>
                            </figure>
                            <div class="card-body m-0 p-0">
                              <div class="entry-header mb-3">
                                <ul class="">
                                  <li class="">
                                    <a class="fs-5 link-secondary text-decoration-none d-flex align-items-center" href="#!">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mr-2 bi bi-calendar3" viewBox="0 0 16 16">
                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
                                        <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                      </svg>
                                      <span class="ms-2 fs-5">{{ optional($post->start_date)->translatedFormat('d F Y') }}</span>
                                    </a>
                                  </li>
                                    <li class="mt-2" >
                                    <a class="fs-5 link-secondary text-decoration-none d-flex align-items-center" href="#!">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mr-2 bi bi-ticket-detailed" viewBox="0 0 16 16">
                                        <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2z"/>
                                        <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5z"/>
                                      </svg>
                                      <span class="ms-2 fs-5">{{$post->price}}</span>
                                    </a>
                                  </li>
                                </ul>
                               <h2 class="card-title  entry-title h4 m-0 mt-2">
                                  <h1 class="link-dark  text-decoration-none" >{{ $post->title }}</h1>
                                </h2>
                                <ul class="entry-meta list-unstyled d-flex mt-2">
                                  <li>
                                    @foreach($post->tags as $tag)
                                        <a class="d-inline-flex px-2 py-1 me-1 mb-1 link-primary text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2 text-decoration-none fs-7">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                  </li>
                                </ul>
                                
                               
                            
                              </div>
                            </div>
                          </div>
                        </article>
                      </div>
              @endforeach      
                </div>
                               
              </div>
              
            {{ $posts->links() }}
          </div>

  <script>
                function confirmDelete(id) {
                  Swal.fire({
                    title: 'Hapus Event',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      document.getElementById('deleteForm' + id).submit();
                    }
                  });
                }
              </script>

@endsection