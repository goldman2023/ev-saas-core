@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0 h6">{{translate('Manual Payment Information')}}</h3>
        </div>

        <form action="{{ route('manual_payment_methods.update', $manual_payment_method->id) }}" method="POST">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="type">{{translate('Type')}}</label>
                    <div class="col-sm-10">
                        <select class="form-control aiz-selectpicker" name="type" id="type" required>
                            <option value="custom_payment" @if($manual_payment_method->type == 'custom_payment') selected @endif>{{translate('Custom Payment')}}</option>
                            <option value="bank_payment" @if($manual_payment_method->type == 'bank_payment') selected @endif>{{translate('Bank Payment')}}</option>
                            <option value="check_payment" @if($manual_payment_method->type == 'check_payment') selected @endif>{{translate('Check Payment')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="name">{{translate('Heading')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="heading" value="{{ $manual_payment_method->heading }}" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Checkout Thumbnail')}} (438x235)px</label>
                    <div class="col-md-8">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="photo" value="{{ $manual_payment_method->photo }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label">{{translate('Payment Instruction')}}</label>
                    <div class="col-sm-10">
                        <textarea class="aiz-text-editor" name="description">@php echo $manual_payment_method->description @endphp</textarea>
                    </div>
                </div>
                <div id="bank_payment_data">
                    <div id="bank_payment_informations">
                        @if($manual_payment_method->bank_info != null)
                            @foreach (json_decode($manual_payment_method->bank_info) as $key => $bank_info)
                                <div class="form-group row">
                                    <div class="row">
                                        <label class="col-sm-2 col-from-label">{{translate('Bank Information')}}</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-3"><input type="text" name="bank_name[]" class="form-control" placeholder="{{ translate('Bank Name') }}" value={{ $bank_info->bank_name }}></div>
                                                <div class="col-sm-3"><input type="text" name="account_name[]" class="form-control" placeholder="{{ translate('Account Name') }}" value={{ $bank_info->account_name }}></div>
                                                <div class="col-sm-3"><input type="text" name="account_number[]" class="form-control" placeholder="{{ translate('Account Number') }}" value={{ $bank_info->account_number }}></div>
                                                <div class="col-sm-3"><input type="text" name="routing_number[]" class="form-control" placeholder="{{ translate('Routing Number') }}" value={{ $bank_info->routing_number }}></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            @if ($key == 0)
                                                <button type="button" class="btn btn-primary" onclick="addBankInfoRow()">{{ translate('Add More') }}</button>
                                            @else
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-danger" onclick="removeBankInfoRow(this)">{{ translate('Remove') }}</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group mb-3 text-right">
                <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

        <div class="d-none" id="bank_info_row">
            <div class="form-group row">
                <div class="row">
                    <label class="col-sm-2 col-from-label">{{translate('Bank Information')}}</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-3"><input type="text" name="bank_name[]" class="form-control" placeholder="{{ translate('Bank Name') }}"></div>
                            <div class="col-sm-3"><input type="text" name="account_name[]" class="form-control" placeholder="{{ translate('Account Name') }}"></div>
                            <div class="col-sm-3"><input type="text" name="account_number[]" class="form-control" placeholder="{{ translate('Account Number') }}"></div>
                            <div class="col-sm-3"><input type="text" name="routing_number[]" class="form-control" placeholder="{{ translate('Routing Number') }}"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-danger" onclick="removeBankInfoRow(this)">{{translate('Remove')}}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#type').on('change', function(){
                if($('#type').val() == 'bank_payment'){
                    $('#bank_payment_data').show();
                }
                else {
                    $('#bank_payment_data').hide();
                }
            });
        });

        function addBankInfoRow(){
            $('#bank_payment_informations').append($('#bank_info_row').html());
        }

        function removeBankInfoRow(el){
            $(el).closest('.form-group').remove();
        }

    </script>
@endsection
