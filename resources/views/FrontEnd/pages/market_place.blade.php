@extends('FrontEnd.main')

@section('title', 'Market-Place')

@push('style')
    <style>

        .dropdown-toggle::after {
            display: none !important;
        }
    </style>

@endpush

@section('content')
    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <!-- left side -->
        <div class="col-lg-3 col-md-2 text-start">
            <div class="shadow rounded">
                <div class="text-center bg-success text-white py-2 rounded-top">
                    <a href="{{ url('/products') }}" class="fs-5 fw-bold text-white text-decoration-none">Category</a>
                </div>
                <div class="list-group rounded-0 border-0" style=" overflow-x: scroll; max-height: 349px;">

                    @foreach ($category as $cate)
                        <a href="{{ url('category-wise', $cate->slug) }}" class="list-group-item"> {{ $cate->name }} </a>
                    @endforeach
                    {{-- <a href="#" class="list-group-item rounded-bottom"> e-gift </a> --}}
                </div>
            </div>

            <!-- company mirror -->
            <div class="mt-5 mirror shadow rounded">
                <h3 class="text-capitalize text-success text-center py-3">
                    Mirror Links
                </h3>
                <div class="list-group rounded-0" style=" overflow-x: scroll; max-height: 349px; ">
                    @if(isset($m_links))
                        @foreach ($m_links as $key=> $link)
                            <a href="{{ $link->link }}" target="_blank" class="list-group-item  border-0" title="{{ $link->link }}"> {{ ++$key }}. <u>{{ $link->title }}</u> </a>
                        @endforeach
                    @endif
                </div>
                {{-- <div class="img-container rounded-bottom">
                </div> --}}
            </div>
        </div>

        <!-- right side top part -->
        <div class="col-lg-8 col-md-10 text-start">
            <div class="p-3 user-div shadow rounded">
                <div class="mb-4 text-capitalize inner-content">
                    <p class="mb-1">Hello, user</p>
                    <p class="mb-0">
                        welcome to digital marketplace if you have any question,
                        problem suggestion or a request <br>
                        <a href="{{ url('/support') }}" rel="noopener noreferrer">feel free to open a ticket</a >
                    </p>
                </div>
            </div>

            <!-- right side news part -->
            <div class="mt-5 p-3 shadow rounded news">
                <h2 class="text-capitalize text-start mb-3 fw-bold text-success">News</h2>
                <div style=" overflow-x: scroll; max-height: 349px; ">
                    @if(isset($newsMarket))
                        @foreach ($newsMarket as $new)
                            <p class="text-capitalize">
                                {{-- <a href="http://" target="_blank" rel="noopener noreferrer"> --}}
                                    {{ date('d/m/Y',strtotime($new->created_at)) }} <br />
                                <strong style="cursor: pointer;" >{{ $new->header }}</strong>
                                {{-- </a> --}}
                            </p>
                        @endforeach
                        {{ $newsMarket->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

@endpush
