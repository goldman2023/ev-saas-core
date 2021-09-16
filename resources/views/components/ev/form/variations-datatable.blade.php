<div class="variations-datatable">
    @if(!empty($variationAttributes))
        <div class="table-responsive datatable-custom" >
            <table @if($id) id="{{ $id }}" @endif class="variations-datatables table-borderless table-thead-bordered table-nowrap table-align-middle card-table {{ $tableClass }}"
                   data-hs-datatables-options='@json($options)'>
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Name') }}</th>
                        @foreach($variationAttributes as $att_id => $att)
                            @php $att = is_array($att) ? (object) $att : $att; @endphp
                            <th>{{ $att->name }}</th>
                        @endforeach
                        <th></th>
                        <!--<th>{{ translate('Price') }}</th>
                        <th>{{ translate('Qty') }}</th>
                        <th>{{ translate('SKU') }}</th>
                        <th>{{ translate('Options') }}</th>-->
                    </tr>
                </thead>
                <tbody>
                    @if(empty($variations))
                        <tr>{{ translate('There are no variations yet.') }}</tr>
                    @endif
                </tbody>
            </table>

        </div>
    @endif
</div>


