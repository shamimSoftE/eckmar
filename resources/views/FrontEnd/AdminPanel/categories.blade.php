@extends('FrontEnd.main')

@section('title', 'Category')

@push('style')
<style>
    .c_active{ color: #ffffff; background-color: #198754; }
    .c_text{font-size: 12px!important; text-decoration: none!important; }
    .cc_body {min-height: 115px!important; }
    table, td { font-size: 12px; }

    /* Box styles */
.cateList {
    border: none;
    padding: 5px;
    font: 24px/36px sans-serif;
    width: 200px;
    height: 200px;
    overflow: scroll;
}

</style>
@endpush

@section('content')

    <div class="row g-2 justify-content-between mt-5 mb-3 mx-0 px-5">
        <!-- left side -->
        <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-2 text-start">
            <div class="shadow rounded">
                <div class="text-center py-2 rounded-top @if(request()->segment(1) == 'admin-panel') c_active @endif">
                    <a href="{{ url('/admin-panel') }}" class="text-decoration-none text-dark ">Market Statistics</a>
                </div>
                @include('FrontEnd.AdminPanel.include.sidebar')
            </div>

        </div>

        <!-- right side top part -->
        <div class="col-xl-8 col-xxl-8 col-lg-8 col-md-10 text-start">
            <div class="p-3 user-div shadow rounded">
                <div class="mb-4 inner-content">
                    <div class="row">


                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                            <h3 class="text-center pb-3">List of Category
                                <button type="button" class="btn btn-success btn-sm position-relative">
                                    Total <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> {{ count($categoryC) }} </span>
                                </button>
                            </h3>

                            <div class="card cateList" style="width: 18rem;" >
                                <ul class="list-group list-group-flush">
                                    @foreach ($category as $cate)
                                        <li class="list-group-item c_text text-dark">
                                             {{ $cate->name }}
                                             <a href="{{ url('category_destroy', App\Models\Magician::ed($cate->id)) }}" class="btn btn-outline-danger btn-sm c_text text-dark" title="Click to delete it"><i class="fa-solid fa-trash"></i></a>
                                            @if(!empty(count($cate->subCategories)))
                                                <ul>
                                                    @foreach ($cate->subCategories as $subCat)
                                                        <li class="list-item c_text text-dark">
                                                            {{ $subCat->name }} <a href="{{ url('category_destroy', App\Models\Magician::ed($subCat->id)) }}" class="btn btn-outline-danger btn-sm c_text text-dark" title="Click to delete it"><i class="fa-solid fa-trash"></i></a>

                                                            @if(!empty(count($subCat->subCategories)))
                                                                <ul>
                                                                    @foreach ($subCat->subCategories as $ssCat)
                                                                        <li class="list-item c_text text-dark">
                                                                             {{ $ssCat->name }} <a href="{{ url('category_destroy', App\Models\Magician::ed($ssCat->id)) }}" class="btn btn-outline-danger btn-sm c_text text-dark" title="Click to delete it"><i class="fa-solid fa-trash"></i></a>
                                                                            @if(!empty(count($ssCat->subCategories)))
                                                                                <ul>
                                                                                    @foreach ($ssCat->subCategories as $sssCate)
                                                                                        <li class="list-item c_text text-dark"> {{ $sssCate->name }} <a href="{{ url('category_destroy', App\Models\Magician::ed($sssCate->id)) }}" class="btn btn-outline-danger btn-sm c_text text-dark" title="Click to delete it"><i class="fa-solid fa-trash"></i></a></li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                        </div>

                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                            <h3 class="text-center pb-3">Add New Category</h3>
                            <div class="card p-3">
                                <form method="POST" action="{{ route('category.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Category Name" required>
                                        @error('name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="parent_id" class="form-lable">Parent Category</label>
                                        <select class="form-select form-select-sm" name="parent_id" aria-label=".form-select-sm example">
                                            <option value="">Select Parent Category</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @if(!empty(count($cat->subCategories)))
                                                    @foreach ($cat->subCategories as $subCate)

                                                        <option value="{{ $subCate->id }}">=>{{ $subCate->name }}</option>

                                                        @if(!empty(count($subCate->subCategories)))

                                                        @foreach ($subCate->subCategories as $ssCate)
                                                            <option value="{{ $ssCate->id }}">===>{{ $ssCate->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm float-end">Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
