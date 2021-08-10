<div class="card d-none">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Subsidiary Companies and Representatives') }}</h5>
    </div>
    <div class="card-body">
        <div class="row gutters-10">
            @foreach (auth()->user()->addresses as $key => $address)
                <div class="col-lg-6">
                    <div class="border p-3 pr-5 rounded mb-3 position-relative">
                        <div>
                            <span class="w-50 fw-600">{{ translate('Address') }}:</span>
                            <span class="ml-2">{{ $address->address }}</span>
                        </div>
                        <div>
                            <span class="w-50 fw-600">{{ translate('Postal Code') }}:</span>
                            <span class="ml-2">{{ $address->postal_code }}</span>
                        </div>
                        <div>
                            <span class="w-50 fw-600">{{ translate('City') }}:</span>
                            <span class="ml-2">{{ $address->city }}</span>
                        </div>
                        <div>
                            <span class="w-50 fw-600">{{ translate('Country') }}:</span>
                            <span class="ml-2">{{ $address->country }}</span>
                        </div>
                        <div>
                            <span class="w-50 fw-600">{{ translate('Phone') }}:</span>
                            <span class="ml-2">{{ $address->phone }}</span>
                        </div>
                        @if ($address->set_default)
                            <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                                <span class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                            </div>
                        @endif
                        <div class="dropdown position-absolute right-0 top-0">
                            <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                                <i class="la la-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" onclick="edit_address('{{ $address->id }}')">
                                    {{ translate('Edit') }}
                                </a>
                                @if (!$address->set_default)
                                    <a class="dropdown-item"
                                        href="{{ route('addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                @endif
                                <a class="dropdown-item"
                                    href="{{ route('addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                    <i class="la la-plus la-2x"></i>
                    <div class="alpha-7">{{ translate('Add New Subsidiary Company or Representative') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
