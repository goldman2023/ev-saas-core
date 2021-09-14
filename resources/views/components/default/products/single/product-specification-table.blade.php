<div class="table-responsive">
    <table class="table table-thead-bordered table-nowrap table-align-middle">
        <thead class="thead-light">
            <tr>
                <th>{{ translate('Product Specification') }}</th>
                <th>{{ translate('Value') }}</th>
                <th style="width: 5%;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product_attributes as $attribute)
                @php
                    $attribute_value = $product
                        ->attributes()
                        ->where('attribute_id', $attribute->id)
                        ->first();
                @endphp
                @isset($attribute_value)
                <tr>

                    <td><a href="#">{{ $attribute->name }}</a></td>
                    <td>
                    {{ $attribute_value->attribute_value->values; }}
                    </td>
                </tr>
                @endisset
            @endforeach


        </tbody>
    </table>
</div>
<!-- End Table -->
