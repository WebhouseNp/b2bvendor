<button type="button" class="btn btn-primary pull-right" onclick="addVariantRow()">Add</button>
<table class="table" id="variantTbl">
    <thead>
        <tr>
            @foreach($attributes as $attribute)
            <th>{{ $attribute->title }}</th>
            @endforeach
            <th>Price</th>
            <th>Discount Price</th>
            <th>Stock</th>
            <th>SKU</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 2; $i++) 
        <tr style="{{ $i==0?'display: none':'' }}">
            @foreach($attributes as $k=>$attribute)
            <td >
                @php
                $options = unserialize($attribute->options);
                @endphp
                <select class="form-control" style="width: 100px;" name="variant[{{$attribute->id}}][]">
                    <option value="">Select</option>
                    @foreach($options as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>


            </td>
            @endforeach
            <td><input class="form-control" id="variant_price" name="variant[price][]"  /></td>
            <td><input class="form-control" id="variant_discount_price" name="variant[discount_price][]" ></td>
            <td><input class="form-control" id="variant_stock" name="variant[stock][]" ></td>
            <td><input class="form-control" id="sku" name="variant[sku][]" ></td>
            <td><button type="button" class="btn btn-danger remove-variant"
                    onclick="if(confirm('Are you want to remove this row')){$(this).closest('tr').remove()}">Remove</button>
            </td>

            </tr>
            @endfor

    </tbody>
</table>
