<form class="form-horizontal" action="{{ route('seller.category.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Select Company Industries')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{translate('Industry')}}</label>
                    <div class="col-md-8">
                    {{-- TODO: Make maximum count of categories 5 --}}
                        <select class="select2 form-control aiz-selectpicker" name="categories[]" multiple data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if(in_array($category->id, $user->shop->categories->pluck('id')->toArray())) selected @endif>{{ $category->getTranslation('name') }}</option>
                                @foreach ($category->childrenCategories as $childCategory)
                                    @include('categories.child_category', ['child_category' => $childCategory, 'categoryIds' => $user->shop->categories->pluck('id')->toArray()])
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Update Category')}}</button>
                </div>
            </div>
        </div>        
    </form>