                @if($shippingMethod=='inhouse_shipping')
                        <?php
                        $isPhysicalProductExist = false;
                        foreach ($cart as $group_key => $group) {
                            foreach ($group as $row) {
                                if ($row->product_type == 'physical' && $row->is_checked) {
                                    $isPhysicalProductExist = true;
                                }
                            }
                        }
                        ?>
        
                        <?php
                        $admin_shipping = \App\Models\ShippingType::where('seller_id', 0)->first();
                        $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                        ?>
                    @if ($shipping_type == 'order_wise' && $isPhysicalProductExist)
                        @php($shippings=\App\Utils\Helpers::get_shipping_methods(1,'admin'))
                        @php($chosenShipping=\App\Models\CartShipping::where(['cart_group_id'=>$cartItem['cart_group_id']])->first())
        
                        @if(isset($chosenShipping)==false)
                            @php($chosenShipping['shipping_method_id']=0)
                        @endif
                        <div class="px-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-control border-aliceblue action-set-shipping-id"
                                            data-product-id="all_cart_group">
                                        <option>{{ translate('choose_shipping_method')}}</option>
                                        @foreach($shippings as $shipping)
                                            <option
                                                value="{{$shipping['id']}}" {{$chosenShipping['shipping_method_id']==$shipping['id']?'selected':''}}>
                                                {{ translate('shipping_method')}}
                                                : {{$shipping['title'].' ( '.$shipping['duration'].' ) '.webCurrencyConverter(amount: $shipping['cost'])}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
